<?php

namespace App\Http\Controllers;

use App\Models\dudiModel;
use App\Models\jurnalModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\tugasModel;
use App\Models\tugasStatusModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use RuntimeException;

class userSiswaController extends Controller
{
    // # ===== LOGIN ===== ##
    public function login()
    {
        //
    }

    public function attemptLogin(Request $request)
    {
        //
    }

    public function logout(Request $request)
    {
        //
    }

    // # ===== DASHBOARD ===== ##
    public function dashboard()
    {
        return view('userSiswa.dashboard');
    }

    // # ===== PENDAFTARAN ===== ##
    public function pendaftaran()
    {
        $pendaftaran = pendaftaranModel::query()
            ->whereNotNull('id_siswa')
            ->where('id_siswa', '!=', '')
            ->whereHas('siswa')
            ->with('siswa.kelas', 'siswa.pendaftaran.dudi')
            ->latest('id')
            ->first();

        if ($pendaftaran !== null) {
            return view('userSiswa.pendaftaran.status', ['siswa' => $pendaftaran->siswa]);
        }

        $dudi = dudiModel::query()->get();

        return view('userSiswa.pendaftaran.pendaftaran', compact('dudi'));
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

        return redirect()->route('userSiswa.pendaftaran')->with('success', 'Pendaftaran berhasil dikirim.');
    }

    public function editPendaftaran(): View|RedirectResponse
    {
        $pendaftaran = pendaftaranModel::query()
            ->whereNotNull('id_siswa')
            ->where('id_siswa', '!=', '')
            ->whereHas('siswa')
            ->with('siswa')
            ->latest('id')
            ->firstOrFail();

        if ($pendaftaran->status === 'disetujui') {
            return redirect()->route('userSiswa.pendaftaran')
                ->with('error', 'DUDI tidak dapat diubah setelah pendaftaran disetujui.');
        }

        $dudi = dudiModel::query()->get();

        return view('userSiswa.pendaftaran.pendaftaran', compact('dudi', 'pendaftaran'));
    }

    public function updatePendaftaran(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'dudi' => [
                'required',
                'integer',
                Rule::exists('tb_dudi', 'id')->whereNull('deleted_at'),
            ],
        ]);

        $pendaftaran = pendaftaranModel::query()
            ->whereNotNull('id_siswa')
            ->where('id_siswa', '!=', '')
            ->whereHas('siswa')
            ->latest('id')
            ->firstOrFail();

        if ($pendaftaran->status === 'disetujui') {
            return redirect()->route('userSiswa.pendaftaran')
                ->with('error', 'DUDI tidak dapat diubah setelah pendaftaran disetujui.');
        }

        $updated = pendaftaranModel::query()
            ->whereKey($pendaftaran->getKey())
            ->whereIn('status', ['pending', 'ditolak'])
            ->update([
                'id_dudi' => (string) $validated['dudi'],
            ]);

        if ($updated === 0) {
            return redirect()->route('userSiswa.pendaftaran')
                ->with('error', 'Status pendaftaran sudah berubah. DUDI tidak dapat diubah.');
        }

        return redirect()->route('userSiswa.pendaftaran')->with('success', 'Tempat PKL berhasil diperbarui.');
    }

    // # ===== ABSENSI ===== ##
    public function absensi()
    {
        //
    }
    // # ===== JURNAL ===== ##
    public function jurnal(Request $request): View
    {
        $siswa = siswaModel::query()
            ->where('status', 'active')
            ->orderBy('nama')
            ->get(['id', 'nama']);
        $selectedStudentId = filter_var($request->query('id_siswa'), FILTER_VALIDATE_INT);

        if (! is_int($selectedStudentId) || ! $siswa->contains('id', $selectedStudentId)) {
            $selectedStudentId = null;
        }

        $query = jurnalModel::query();
        if ($selectedStudentId === null) {
            $query->whereRaw('1 = 0');
        } else {
            $query->where('id_siswa', $selectedStudentId);
        }

        $search = trim((string) $request->query('search', ''));
        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('tanggal', 'like', "%{$search}%")
                    ->orWhere('kegiatan', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->query('perPage', 15);
        if (! in_array($perPage, [15, 25, 50, 100], true)) {
            $perPage = 15;
        }

        $jurnal = $query
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->appends($request->query());

        return view('userSiswa.jurnal.index', compact('siswa', 'selectedStudentId', 'jurnal'));
    }

    public function addJurnal(Request $request): View
    {
        $siswa = siswaModel::query()
            ->where('status', 'active')
            ->orderBy('nama')
            ->get(['id', 'nama']);
        $selectedStudentId = filter_var($request->query('id_siswa'), FILTER_VALIDATE_INT);

        if (! is_int($selectedStudentId) || ! $siswa->contains('id', $selectedStudentId)) {
            $selectedStudentId = null;
        }

        return view('userSiswa.jurnal.add', compact('siswa', 'selectedStudentId'));
    }

    public function saveJurnal(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_siswa' => [
                'required',
                'integer',
                Rule::exists('tb_siswa', 'id')->whereNull('deleted_at')->where('status', 'active'),
            ],
            'tanggal' => ['required', 'date_format:Y-m-d'],
            'kegiatan' => ['required', 'string', 'max:255'],
        ]);

        jurnalModel::create($validated);

        return redirect()
            ->route('userSiswa.jurnal', ['id_siswa' => $validated['id_siswa']])
            ->with('success', 'Jurnal berhasil ditambahkan.');
    }

    public function editJurnal(Request $request, string $id): View
    {
        $validated = $request->validate([
            'id_siswa' => [
                'required',
                'integer',
                Rule::exists('tb_siswa', 'id')->whereNull('deleted_at')->where('status', 'active'),
            ],
        ]);
        $siswa = siswaModel::query()->findOrFail($validated['id_siswa']);
        $jurnal = jurnalModel::query()
            ->where('id_siswa', $siswa->id)
            ->findOrFail($id);

        return view('userSiswa.jurnal.edit', compact('siswa', 'jurnal'));
    }

    public function updateJurnal(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'id_siswa' => [
                'required',
                'integer',
                Rule::exists('tb_siswa', 'id')->whereNull('deleted_at')->where('status', 'active'),
            ],
            'tanggal' => ['required', 'date_format:Y-m-d'],
            'kegiatan' => ['required', 'string', 'max:255'],
        ]);
        $jurnal = jurnalModel::query()
            ->where('id_siswa', $validated['id_siswa'])
            ->findOrFail($id);

        $jurnal->update([
            'tanggal' => $validated['tanggal'],
            'kegiatan' => $validated['kegiatan'],
        ]);

        return redirect()
            ->route('userSiswa.jurnal', ['id_siswa' => $validated['id_siswa']])
            ->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function deleteJurnal(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'id_siswa' => [
                'required',
                'integer',
                Rule::exists('tb_siswa', 'id')->whereNull('deleted_at')->where('status', 'active'),
            ],
        ]);
        $jurnal = jurnalModel::query()
            ->where('id_siswa', $validated['id_siswa'])
            ->findOrFail($id);
        $jurnal->delete();

        return redirect()
            ->route('userSiswa.jurnal', ['id_siswa' => $validated['id_siswa']])
            ->with('success', 'Jurnal berhasil dihapus.');
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
            'assets/static/pengumpulan-tugas',
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
                'assets/static/pengumpulan-tugas/' . basename($oldFile),
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
                'assets/static/pengumpulan-tugas/' . basename($oldFile),
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
