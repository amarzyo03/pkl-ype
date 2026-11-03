<?php

namespace App\Http\Controllers;

use App\Models\absensiModel;
use App\Models\dudiModel;
use App\Models\jurnalModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\tugasModel;
use App\Models\tugasStatusModel;
use App\Models\userModel;
use Closure;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;

class userSiswaController extends Controller
{
    protected $user_id;

    protected $siswa;

    protected $pendaftaran;

    public function __construct()
    {
        $user = userModel::query()->findOrFail(session('auth_id'));
        $this->user_id = $user->id_user;
        $this->siswa = siswaModel::query()
            ->with(['kelas', 'pendaftaran.dudi'])
            ->findOrFail($this->user_id);
        $this->pendaftaran = $this->siswa->pendaftaran;
    }

    // # ===== DASHBOARD ===== #
    public function dashboard(): View
    {
        $siswa = $this->siswa;
        $pendaftaran = $this->pendaftaran;
        $totalAbsensi = absensiModel::query()->where('id_siswa', $siswa->id)->count();
        $totalJurnal = jurnalModel::query()->where('id_siswa', $siswa->id)->count();
        $totalTugas = tugasModel::query()->count();
        $tugasSelesai = tugasStatusModel::query()
            ->where('id_siswa', $siswa->id)
            ->where('status', 'dikerjakan')
            ->distinct()
            ->count('id_tugas');
        $absensiTerbaru = absensiModel::query()
            ->where('id_siswa', $siswa->id)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->first(['id', 'tanggal', 'status', 'keterangan']);
        $jurnalTerbaru = jurnalModel::query()
            ->where('id_siswa', $siswa->id)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->first(['id', 'tanggal', 'kegiatan']);

        return view('userSiswa.dashboard', compact(
            'siswa',
            'pendaftaran',
            'totalAbsensi',
            'totalJurnal',
            'totalTugas',
            'tugasSelesai',
            'absensiTerbaru',
            'jurnalTerbaru',
        ));
    }

    // # ===== PENDAFTARAN ===== ##
    public function pendaftaran()
    {
        $siswa = $this->siswa;
        $pendaftaran = $this->pendaftaran;
        $dudi = $this->availableDudi();

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
            'id_dudi' => $request->dudi,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('userSiswa.pendaftaran.status')
            ->with('success', 'Pendaftaran berhasil dikirim.');
    }

    public function statusPendaftaran()
    {
        $siswa = $this->siswa;
        $pendaftaran = $this->pendaftaran;

        return view('userSiswa.pendaftaran.status', compact('siswa', 'pendaftaran'));
    }

    public function editPendaftaran()
    {
        $siswa = $this->siswa;
        $pendaftaran = $this->pendaftaran;
        $dudi = $this->availableDudi();

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
        $pendaftaran->id_dudi = $request->dudi;
        $pendaftaran->status = 'pending';
        $pendaftaran->update();

        return redirect()->route('userSiswa.pendaftaran.status')->with('success', 'Perubahan DUDI Berhasil di Simpan');
    }

    // # ===== DAFTAR SISWA ===== ##
    public function daftarSiswa()
    {
        $daftarSiswa = pendaftaranModel::query()
            ->select(['id', 'id_siswa'])
            ->with(['siswa:id,nama,id_kelas', 'siswa.kelas:id,nama'])
            ->where('id_dudi', $this->pendaftaran?->id_dudi)
            ->where('status', 'disetujui')
            ->orderBy('id')
            ->get();

        return view('userSiswa.daftar-siswa.index', compact('daftarSiswa'));
    }

    // # ===== TUGAS ===== ##
    public function tugas(Request $request)
    {
        if ($this->pendaftaran?->status === 'pending') {
            return redirect()->route('userSiswa.pendaftaran.status')->with('failed', 'Status Peserta PKL masih belum disetujui');
        }

        $siswa = $this->siswa->id;
        $tugas = tugasModel::query()
            ->select(['id', 'id_guru', 'tanggal', 'judul'])
            ->with('guru:id,nama')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        return view('userSiswa.tugas.index', compact('tugas'));
    }

    public function tugasKerjakan($id)
    {
        $siswa = $this->siswa;
        $tugas = tugasModel::query()->with('guru:id,nama')->find($id);
        $tugas_status = tugasStatusModel::where('id_siswa', $siswa->id)->where('id_tugas', $tugas->id)->orderByDesc('id')->first();

        return view('userSiswa.tugas.kerjakan', compact('siswa', 'tugas', 'tugas_status'));
    }

    public function attemptTugasKerjakan(Request $request, string $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:1024',
        ]);

        $siswa = $this->siswa->id;
        $siswa_nama = $this->siswa->nama;
        $siswa_kelas = $this->siswa->kelas->nama;
        $tugas = tugasModel::query()->find($id);
        $tanggal = now()->toDateString();
        $file = $request->file('file');
        $nama_file = $siswa_nama.'_'.$siswa_kelas.'_'.$tanggal.'_'.$tugas->judul.'.'.strtolower($file->getClientOriginalExtension());
        $path = Storage::disk('task_attachments')->putFileAs(
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
            'tanggal' => $tanggal,
            'status' => 'dikerjakan',
            'file' => $nama_file,
        ];

        tugasStatusModel::create($data);

        return redirect()
            ->route('userSiswa.tugas.kerjakan', $tugas->id)
            ->with('success', 'Tugas berhasil di kirim');
    }

    public function cancelTugasKerjakan(string $id)
    {
        $siswa = $this->siswa->id;
        $tugas = tugasModel::query()->find($id);
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
            $path = 'assets/static/tugas-pengumpulan/'.basename($nama_file);
            if (! Storage::disk('task_attachments')->delete($path)) {
                throw new RuntimeException('File tugas gagal dihapus saat pengerjaan dibatalkan.');
            }
        }

        $tugas_status->update([
            'status' => null,
            'file' => null,
        ]);

        return redirect()
            ->route('userSiswa.tugas.kerjakan', $tugas->id)
            ->with('success', 'Pengerjaan tugas dibatalkan. Anda dapat mengunggah file kembali.');
    }

    // # ===== ABSENSI ===== ##
    public function absensi()
    {
        $siswa_info = $this->siswa;
        $dudi = $this->pendaftaran;
        $absensi = absensiModel::query()
            ->select(['id', 'tanggal', 'foto', 'keterangan', 'status'])
            ->where('id_siswa', $siswa_info->id)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        return view('userSiswa.absensi.index', compact('absensi', 'siswa_info', 'dudi'));
    }

    public function addAbsensi()
    {
        $siswa = $this->siswa;
        $lokasi = $this->pendaftaran?->dudi?->nama;

        return view('userSiswa.absensi.add', compact('siswa', 'lokasi'));
    }

    public function saveAbsensi(Request $request)
    {
        $request->validate($this->absensiRules(), $this->absensiMessages());

        $foto = $request->file('foto');
        $foto_nama = $this->siswa->id.'_'.now()->format('YmdHis').'_'.Str::random(8).'.'.$foto->extension();
        $path = Storage::disk('task_attachments')->putFileAs(
            'assets/static/absensi',
            $foto,
            $foto_nama
        );

        if ($path === false) {
            throw new RuntimeException('Foto absensi gagal disimpan.');
        }

        $data =
            [
                'id_siswa' => $this->siswa->id,
                'tanggal' => $request->tanggal,
                'status' => $request->status,
                'foto' => $foto_nama,
                'keterangan' => $request->keterangan,
            ];

        absensiModel::create($data);

        return redirect()->route('userSiswa.absensi')->with('success', 'Absensi berhasil disimpan.');
    }

    public function editAbsensi(string $id): View
    {
        $absensi = absensiModel::query()
            ->where('id_siswa', $this->siswa->id)
            ->findOrFail($id);

        return view('userSiswa.absensi.edit', compact('absensi'));
    }

    public function updateAbsensi(Request $request, string $id): RedirectResponse
    {
        $absensi = absensiModel::query()
            ->where('id_siswa', $this->siswa->id)
            ->findOrFail($id);
        $data = $request->validate($this->absensiRules($absensi), $this->absensiMessages());
        $oldPhoto = $absensi->foto;

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->storeAbsensiPhoto($request);
        } else {
            unset($data['foto']);
        }

        $absensi->update($data);

        if (
            isset($data['foto']) && $oldPhoto !== null
            && ! Storage::disk('task_attachments')->delete('assets/static/absensi/'.basename($oldPhoto))
        ) {
            throw new RuntimeException('Foto absensi lama gagal dihapus.');
        }

        return redirect()->route('userSiswa.absensi')->with('success', 'Absensi berhasil diperbarui.');
    }

    private function absensiRules(?absensiModel $absensi = null): array
    {
        return [
            'tanggal' => [
                'required',
                'date',
                'before_or_equal:today',
                function (string $attribute, mixed $value, Closure $fail) use ($absensi): void {
                    $query = absensiModel::query()
                        ->where('id_siswa', $this->siswa->id)
                        ->whereDate('tanggal', $value);

                    if ($absensi !== null) {
                        $query->where('id', '!=', $absensi->id);
                    }

                    if ($query->exists()) {
                        $fail('Absensi untuk tanggal ini sudah pernah diisi.');
                    }
                },
            ],
            'status' => ['required', 'in:hadir,sakit,izin,alpa,libur'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ];
    }

    private function absensiMessages(): array
    {
        return [
            'tanggal.before_or_equal' => 'Tanggal absensi tidak boleh melebihi hari ini.',
        ];
    }

    private function storeAbsensiPhoto(Request $request): string
    {
        $file = $request->file('foto');
        $filename = $this->siswa->id.'_'.now()->format('YmdHis').'_'.Str::random(8).'.'.$file->extension();
        $path = Storage::disk('task_attachments')->putFileAs('assets/static/absensi', $file, $filename);

        if ($path === false) {
            throw new RuntimeException('Foto absensi gagal disimpan.');
        }

        return $filename;
    }

    // # ===== JURNAL ===== ##
    public function jurnal(): View
    {
        $jurnal = jurnalModel::query()
            ->select(['id', 'tanggal', 'kegiatan'])
            ->where('id_siswa', $this->siswa->id)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        return view('userSiswa.jurnal.index', compact('jurnal'));
    }

    public function addJurnal(): View
    {
        $siswa = $this->siswa;

        return view('userSiswa.jurnal.add', compact('siswa'));
    }

    public function saveJurnal(Request $request): RedirectResponse
    {
        $data = $request->validate($this->jurnalRules());
        $data['id_siswa'] = $this->siswa->id;

        jurnalModel::query()->create($data);

        return redirect()->route('userSiswa.jurnal')->with('success', 'Jurnal berhasil disimpan.');
    }

    public function editJurnal(string $id): View
    {
        $jurnal = jurnalModel::query()
            ->where('id_siswa', $this->siswa->id)
            ->findOrFail($id);

        return view('userSiswa.jurnal.edit', compact('jurnal'));
    }

    public function updateJurnal(Request $request, string $id): RedirectResponse
    {
        $jurnal = jurnalModel::query()
            ->where('id_siswa', $this->siswa->id)
            ->findOrFail($id);
        $jurnal->update($request->validate($this->jurnalRules()));

        return redirect()->route('userSiswa.jurnal')->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function deleteJurnal(string $id): RedirectResponse
    {
        $jurnal = jurnalModel::query()
            ->where('id_siswa', $this->siswa->id)
            ->findOrFail($id);
        $jurnal->delete();

        return redirect()->route('userSiswa.jurnal')->with('success', 'Jurnal berhasil dihapus.');
    }

    private function jurnalRules(): array
    {
        return [
            'tanggal' => ['required', 'date', 'before_or_equal:today'],
            'kegiatan' => ['required', 'string', 'max:255'],
        ];
    }

    private function availableDudi(): EloquentCollection
    {
        return dudiModel::query()
            ->select(['id', 'nama', 'id_jurusan'])
            ->with('jurusan:id,nama')
            ->get();
    }
}
