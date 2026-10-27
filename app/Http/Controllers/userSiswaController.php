<?php

namespace App\Http\Controllers;

use App\Models\dudiModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\tugasModel;
use App\Models\tugasStatusModel;
use App\Models\userModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use RuntimeException;

class userSiswaController extends Controller
{
    protected $user_id;
    protected $siswa;
    protected $pendaftaran;

    public function __construct()
    {
        $this->user_id     = userModel::find(session('auth_id'))->id_user;
        $this->siswa       = siswaModel::with('kelas')->find($this->user_id);
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

        return redirect()->route('userSiswa.pendaftaran.status')->with('success', 'Pendaftaran berhasil dikirim.');
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

        $pendaftaran->id_siswa   = $request->nama;
        $pendaftaran->id_dudi    = $request->dudi;
        $pendaftaran->status     = 'pending';
        $pendaftaran->update();

        return redirect()->route('userSiswa.pendaftaran.status')->with('success', 'Perubahan DUDI Berhasil di Simpan');
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

    // # ===== TUGAS ===== ##
    public function tugas(Request $request): View
    {
        $selectedStudentId = filter_var(
            $request->query('id_siswa'),
            FILTER_VALIDATE_INT,
        ) ?: null;
        $tugas = tugasModel::query()
            ->with('guru')
            ->orderByDesc('id')
            ->get();
        $completedTaskIds = $selectedStudentId === null
            ? []
            : tugasStatusModel::query()
            ->where('id_siswa', $selectedStudentId)
            ->where('status', 'dikerjakan')
            ->whereNotNull('file')
            ->pluck('id_tugas')
            ->all();

        return view('userSiswa.tugas.index', compact('tugas', 'selectedStudentId', 'completedTaskIds'));
    }

    public function tugasKerjakan(Request $request, string $id): View
    {
        $tugas = tugasModel::query()->with('guru')->findOrFail($id);
        $siswa = siswaModel::query()->where('status', 'active')->orderBy('nama')->get(['id', 'nama']);
        $selectedStudentId = filter_var(
            old('id_siswa', $request->query('id_siswa')),
            FILTER_VALIDATE_INT,
        ) ?: null;
        $selectedStudent = $siswa->firstWhere('id', $selectedStudentId);
        $pengumpulan = $selectedStudentId === null
            ? null
            : tugasStatusModel::query()
            ->where('id_siswa', $selectedStudentId)
            ->where('id_tugas', $tugas->id)
            ->first();

        return view('userSiswa.tugas.kerjakan', compact(
            'tugas',
            'siswa',
            'selectedStudentId',
            'selectedStudent',
            'pengumpulan',
        ));
    }

    public function attemptTugasKerjakan(Request $request, string $id): RedirectResponse
    {
        $tugas = tugasModel::query()->findOrFail($id);
        $validated = $request->validate([
            'id_siswa' => [
                'required',
                'integer',
                Rule::exists('tb_siswa', 'id')
                    ->whereNull('deleted_at')
                    ->where('status', 'active'),
            ],
            'file' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ]);
        $pengumpulan = tugasStatusModel::query()
            ->firstOrNew([
                'id_siswa' => $validated['id_siswa'],
                'id_tugas' => $tugas->id,
            ]);
        $siswa = siswaModel::query()->findOrFail($validated['id_siswa']);
        $filename = (Str::slug($siswa->nama) ?: 'siswa')
            . '_' . $tugas->id . '_'
            . (Str::slug($tugas->judul) ?: 'tugas')
            . '_siswa-' . $siswa->id
            . '.pdf';
        $oldFile = $pengumpulan->file;
        $newFilePath = Storage::disk('task_attachments')->putFileAs(
            'assets/static/tugas-pengumpulan',
            $request->file('file'),
            $filename,
        );

        if ($newFilePath === false) {
            throw new RuntimeException('File tugas gagal disimpan.');
        }

        $pengumpulan->status = 'dikerjakan';
        $pengumpulan->file = $filename;
        $pengumpulan->tanggal = now()->toDateString();
        $pengumpulan->save();

        if (
            $oldFile !== null
            && basename($oldFile) !== $filename
            && ! Storage::disk('task_attachments')->delete(
                'assets/static/tugas-pengumpulan/' . basename($oldFile),
            )
        ) {
            throw new RuntimeException('File tugas lama gagal dihapus saat mengunggah file baru.');
        }

        return redirect()
            ->route('userSiswa.tugas.kerjakan', [
                'id' => $tugas->id,
                'id_siswa' => $validated['id_siswa'],
            ])
            ->with('success', 'Tugas berhasil dikerjakan dan file berhasil diunggah.');
    }

    public function cancelTugasKerjakan(Request $request, string $id): RedirectResponse
    {
        $tugas = tugasModel::query()->findOrFail($id);
        $validated = $request->validate([
            'id_siswa' => [
                'required',
                'integer',
                Rule::exists('tb_siswa', 'id')
                    ->whereNull('deleted_at')
                    ->where('status', 'active'),
            ],
        ]);
        $pengumpulan = tugasStatusModel::query()
            ->where('id_siswa', $validated['id_siswa'])
            ->where('id_tugas', $tugas->id)
            ->firstOrFail();

        if ($pengumpulan->status !== 'dikerjakan') {
            return redirect()
                ->route('userSiswa.tugas.kerjakan', [
                    'id' => $tugas->id,
                    'id_siswa' => $validated['id_siswa'],
                ])
                ->with('error', 'Tugas belum dikerjakan.');
        }

        $oldFile = $pengumpulan->file;
        $pengumpulan->update([
            'status' => null,
            'file' => null,
        ]);

        if (
            $oldFile !== null
            && ! Storage::disk('task_attachments')->delete(
                'assets/static/tugas-pengumpulan/' . basename($oldFile),
            )
        ) {
            throw new RuntimeException('File tugas gagal dihapus saat pengerjaan dibatalkan.');
        }

        return redirect()
            ->route('userSiswa.tugas.kerjakan', [
                'id' => $tugas->id,
                'id_siswa' => $validated['id_siswa'],
            ])
            ->with('success', 'Pengerjaan tugas dibatalkan. Anda dapat mengunggah file kembali.');
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
