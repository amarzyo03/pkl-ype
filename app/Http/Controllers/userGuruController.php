<?php

namespace App\Http\Controllers;

use App\Models\absensiModel;
use App\Models\dudiModel;
use App\Models\guruModel;
use App\Models\siswaModel;
use App\Models\tugasModel;
use App\Models\tugasStatusModel;
use App\Models\userModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class userGuruController extends Controller
{
    protected $user_id;

    protected $guru;

    public function __construct()
    {
        $this->user_id = userModel::find(session('auth_id'))->id_user;
        $this->guru = guruModel::find($this->user_id);
    }

    public function dashboard()
    {
        return view('userGuru.dashboard.index');
    }

    public function daftarSiswa(): View
    {
        $siswas = siswaModel::query()
            ->with(['kelas', 'pendaftaran.dudi'])
            ->whereHas('pendaftaran.dudi', function (Builder $query): void {
                $query->where('id_guru', $this->guru->id);
            })
            ->orderBy('nama')
            ->get();

        return view('userGuru.daftar-siswa.index', compact('siswas'));
    }

    public function daftarDudi(): View
    {
        $dudi = dudiModel::query()
            ->with(['jurusan', 'guru'])
            ->where('id_guru', $this->guru->id)
            ->get();

        return view('userGuru.daftar-dudi.index', compact('dudi'));
    }

    public function tugas(Request $request): View
    {
        $query = tugasModel::query()
            ->with('guru')
            ->where('id_guru', $this->guru->id);
        $search = trim($request->string('search')->toString());

        if ($search !== '') {
            $query->where(function (Builder $query) use ($search): void {
                $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhereHas('guru', function (Builder $guruQuery) use ($search): void {
                        $guruQuery->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        $perPage = (int) $request->input('perPage', 15);
        if (! in_array($perPage, [15, 25, 50, 100], true)) {
            $perPage = 15;
        }

        $tugas = $query
            ->orderByDesc('id')
            ->paginate($perPage)
            ->appends($request->query());
        $guru = $this->guru;

        if ($request->ajax()) {
            return view('userGuru.tugas._results', compact('tugas'));
        }

        return view('userGuru.tugas.index', compact('tugas', 'guru', 'search'));
    }

    public function statusTugas(string $id): View
    {
        $tugas = $this->ownedTasks()->findOrFail($id);
        $siswas = siswaModel::query()
            ->with('kelas')
            ->whereHas('pendaftaran', function (Builder $query): void {
                $query->where('status', 'disetujui')
                    ->whereHas('dudi', function (Builder $dudiQuery): void {
                        $dudiQuery->where('id_guru', $this->guru->id);
                    });
            })
            ->orderBy('nama')
            ->get();
        $siswaSelesaiIds = tugasStatusModel::query()
            ->where('id_tugas', $tugas->id)
            ->where('status', 'dikerjakan')
            ->whereIn('id_siswa', $siswas->modelKeys())
            ->pluck('id_siswa');
        $siswaSelesai = $siswas->whereIn('id', $siswaSelesaiIds);
        $siswaBelum = $siswas->whereNotIn('id', $siswaSelesaiIds);
        $jumlahSelesai = $siswaSelesai->count();
        $jumlahBelum = $siswaBelum->count();

        return view('userGuru.tugas.status', compact(
            'tugas',
            'siswas',
            'siswaSelesaiIds',
            'jumlahSelesai',
            'jumlahBelum',
        ));
    }

    public function addTugas(): View
    {
        $guru = $this->guru;

        return view('userGuru.tugas.add', compact('guru'));
    }

    public function saveTugas(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $validated['id_guru'] = $this->guru->id;
        $validated['file'] = $request->hasFile('file')
            ? $this->storeAttachment($request, $validated['tanggal'], $validated['judul'])
            : null;

        tugasModel::query()->create($validated);

        return redirect()->route('tugas')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function editTugas(string $id): View
    {
        $tugas = $this->ownedTasks()->with('guru')->findOrFail($id);
        $guru = $this->guru;

        return view('userGuru.tugas.edit', compact('tugas', 'guru'));
    }

    public function updateTugas(Request $request, string $id): RedirectResponse
    {
        $tugas = $this->ownedTasks()->findOrFail($id);
        $validated = $request->validate($this->rules());
        $oldFile = $tugas->file;
        $validated['id_guru'] = $this->guru->id;

        if ($request->hasFile('file')) {
            $validated['file'] = $this->storeAttachment($request, $validated['tanggal'], $validated['judul']);
        } else {
            unset($validated['file']);
        }

        $tugas->update($validated);

        if (isset($validated['file']) && $oldFile !== null && basename($oldFile) !== $validated['file']) {
            Storage::disk('task_attachments')->delete($this->attachmentPath($oldFile));
        }

        return redirect()->route('tugas')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function deleteTugas(string $id): RedirectResponse
    {
        $tugas = $this->ownedTasks()->findOrFail($id);
        $file = $tugas->file;
        $tugas->delete();

        if ($file !== null) {
            Storage::disk('task_attachments')->delete($this->attachmentPath($file));
        }

        return redirect()->route('tugas')->with('success', 'Tugas berhasil dihapus.');
    }

    public function downloadTugasFile(string $id): StreamedResponse
    {
        $tugas = $this->ownedTasks()->findOrFail($id);
        /** @var FilesystemAdapter $storage */
        $storage = Storage::disk('task_attachments');
        $path = $tugas->file === null ? null : $this->attachmentPath($tugas->file);
        abort_unless($path !== null && $storage->exists($path), 404);

        return $storage->download($path, basename($tugas->file));
    }

    public function absensi(Request $request): View
    {
        $validated = $request->validate([
            'tanggal' => ['nullable', 'date_format:Y-m-d'],
        ]);
        $tanggal = $validated['tanggal'] ?? null;
        $absensi = absensiModel::query()
            ->with(['siswa.kelas', 'siswa.pendaftaran.dudi'])
            ->when($tanggal !== null, function (Builder $query) use ($tanggal): void {
                $query->whereDate('tanggal', $tanggal);
            })
            ->whereHas('siswa.pendaftaran', function (Builder $query): void {
                $query->where('status', 'disetujui')
                    ->whereHas('dudi', function (Builder $dudiQuery): void {
                        $dudiQuery->where('id_guru', $this->guru->id);
                    });
            })
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        if ($request->ajax()) {
            return view('userGuru.absensi._results', compact('absensi', 'tanggal'));
        }

        return view('userGuru.absensi.index', compact('absensi', 'tanggal'));
    }

    public function jurnal()
    {
        return view('userGuru.jurnal.index');
    }

    private function ownedTasks(): Builder
    {
        return tugasModel::query()->where('id_guru', $this->guru->id);
    }

    private function storeAttachment(Request $request, string $tanggal, string $judul): string
    {
        $date = Carbon::parse($tanggal)->format('Y-m-d');
        $filename = $date.'_'.(Str::slug($judul) ?: 'tugas').'.pdf';
        $storedPath = Storage::disk('task_attachments')->putFileAs(
            'assets/static/tugas',
            $request->file('file'),
            $filename,
        );

        if ($storedPath === false) {
            throw new RuntimeException('Lampiran tugas gagal disimpan.');
        }

        return $filename;
    }

    private function attachmentPath(string $filename): string
    {
        return 'assets/static/tugas/'.basename($filename);
    }

    private function rules(): array
    {
        return [
            'tanggal' => ['required', 'date'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'file' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:20480',
            ],
        ];
    }
}
