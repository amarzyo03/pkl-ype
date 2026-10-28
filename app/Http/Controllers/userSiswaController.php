<?php

namespace App\Http\Controllers;

use App\Models\dudiModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\tugasModel;
use App\Models\tugasStatusModel;
use App\Models\userModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class userSiswaController extends Controller
{
    protected $user_id;
    protected $siswa;
    protected $pendaftaran;

    public function __construct()
    {
        $this->user_id = userModel::find(session('auth_id'))->id_user;
        $this->siswa = siswaModel::with('kelas')->find($this->user_id);
        $this->pendaftaran = pendaftaranModel::with('siswa', 'dudi')->where('id_siswa', $this->user_id)->first();
    }

    // # ===== DASHBOARD ===== #
    public function dashboard()
    {
        return view('userSiswa.dashboard');
    }

    // # ===== PENDAFTARAN ===== ##
    public function pendaftaran()
    {
        $siswa       = $this->siswa;
        $pendaftaran = $this->pendaftaran;
        $dudi        = dudiModel::all();

        if ($pendaftaran) {
            return redirect()->route('userSiswa.pendaftaran.status');
        }

        return view('userSiswa.pendaftaran.pendaftaran', compact('siswa', 'dudi'));
    }

    public function attemptPendaftaran(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'integer', 'max:255'],
            'dudi' => ['required', 'integer'],
        ]);

        pendaftaranModel::create([
            'id_siswa' => $request->nama,
            'id_dudi'  => $request->dudi,
            'status'   => 'pending',
        ]);

        return redirect()
            ->route('userSiswa.pendaftaran.status')
            ->with('success', 'Pendaftaran berhasil dikirim.');
    }

    public function statusPendaftaran()
    {
        $siswa       = $this->siswa;
        $pendaftaran = $this->pendaftaran;

        return view('userSiswa.pendaftaran.status', compact('siswa', 'pendaftaran'));
    }

    public function editPendaftaran()
    {
        $siswa       = $this->siswa;
        $pendaftaran = $this->pendaftaran;
        $dudi        = dudiModel::all();

        return view('userSiswa.pendaftaran.edit', compact('siswa', 'pendaftaran', 'dudi'));
    }

    public function updatePendaftaran(Request $request, $id)
    {
        $request->validate([
            'nama' => ['required', 'integer', 'max:255'],
            'dudi' => ['required', 'integer'],
        ]);

        $pendaftaran = pendaftaranModel::find($id);

        $pendaftaran->id_siswa = $request->nama;
        $pendaftaran->id_dudi  = $request->dudi;
        $pendaftaran->status   = 'pending';
        $pendaftaran->update();

        return redirect()
            ->route('userSiswa.pendaftaran.status')
            ->with('success', 'Perubahan DUDI Berhasil di Simpan');
    }

    // # ===== TUGAS ===== ##
    public function tugas(Request $request)
    {
        if ($this->pendaftaran?->status === 'pending') {
            return redirect()
                ->route('userSiswa.pendaftaran.status')
                ->with('failed', 'Status Peserta PKL masih belum disetujui');
        }

        $siswa = $this->siswa->id;
        $tugas = tugasModel::with('guru')->get();

        return view('userSiswa.tugas.index', compact('tugas'));
    }

    public function tugasKerjakan($id)
    {
        $siswa = $this->siswa;
        $tugas = tugasModel::query()->with('guru')->findOrFail($id);
        $tugas_status = tugasStatusModel::query()
            ->where('id_siswa', $siswa->id)
            ->where('id_tugas', $tugas->id)
            ->orderByDesc('id')
            ->first();

        return view('userSiswa.tugas.kerjakan', compact('siswa', 'tugas', 'tugas_status'));
    }

    public function attemptTugasKerjakan(Request $request, string $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:1024',
        ]);

        $siswa      = $this->siswa->id;
        $siswa_nama = $this->siswa->nama;
        $siswa_kelas = $this->siswa->kelas->nama;
        $tugas      = tugasModel::with('guru')->find($id);
        $file       = $request->file('file');
        $tanggal    = now()->toDateString();
        $nama_file  = $siswa_nama . '_' . $siswa_kelas . '_' . $tanggal . '_' . $tugas->judul . '.' . strtolower($file->getClientOriginalExtension());
        $path       = Storage::disk('task_attachments')->putFileAs(
            'assets/static/tugas-pengumpulan',
            $file,
            $nama_file,
        );

        if ($path === false) {
            throw new RuntimeException('File tugas gagal disimpan.');
        }

        $data = [
            'id_siswa' => $siswa,
            'id_tugas' => $tugas->id,
            'tanggal'  => $tanggal,
            'status'   => 'dikerjakan',
            'file'     => $nama_file,
        ];

        tugasStatusModel::query()->create($data);

        return redirect()
            ->route('userSiswa.tugas.kerjakan', $tugas->id)
            ->with('success', 'Tugas berhasil di kirim');
    }

    public function cancelTugasKerjakan(string $id): RedirectResponse
    {
        $siswa = $this->siswa->id;
        $tugas = tugasModel::query()->findOrFail($id);
        $tugas_status = tugasStatusModel::query()
            ->where('id_siswa', $siswa)
            ->where('id_tugas', $tugas->id)
            ->orderByDesc('id')
            ->firstOrFail();

        if ($tugas_status->status !== 'dikerjakan') {
            return redirect()
                ->route('userSiswa.tugas.kerjakan', $tugas->id)
                ->with('error', 'Tugas belum dikerjakan.');
        }

        $nama_file = $tugas_status->file;
        if ($nama_file !== null) {
            $path = 'assets/static/tugas-pengumpulan/' . basename($nama_file);
            if (! Storage::disk('task_attachments')->delete($path)) {
                throw new RuntimeException('File tugas gagal dihapus saat pengerjaan dibatalkan.');
            }
        }

        $tugas_status->update([
            'status' => null,
            'file'   => null,
        ]);

        return redirect()
            ->route('userSiswa.tugas.kerjakan', $tugas->id)
            ->with('success', 'Pengerjaan tugas dibatalkan. Anda dapat mengunggah file kembali.');
    }

    // # ===== ABSENSI ===== ##
    public function absensi()
    {
        //
    }

    // # ===== JURNAL ===== ##
    public function jurnal()
    {
        //
    }

    // # ===== PROFIL ===== ##
    public function profile()
    {
        //
    }

    public function updateProfile(Request $request)
    {
        //
    }
}
