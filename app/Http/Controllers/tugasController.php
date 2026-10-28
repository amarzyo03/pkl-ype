<?php

namespace App\Http\Controllers;

use App\Models\guruModel;
use App\Models\tugasModel;
use App\Models\userModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class tugasController extends Controller
{
    protected $user_id;

    protected $guru;

    public function __construct()
    {
        $this->user_id = userModel::find(session('auth_id'))->id_user;
        $this->guru = guruModel::find($this->user_id);
    }

    public function index(Request $request): View
    {
        $query = tugasModel::query()->with('guru');
        $search = trim((string) $request->input('search', ''));

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

        $tugases = $query
            ->orderByDesc('id')
            ->paginate($perPage)
            ->appends($request->query());

        return view('tugas.index', compact('tugases', 'search'));
    }

    public function add(): View
    {
        $guru = $this->guru;

        return view('tugas.add', compact('guru'));
    }

    public function save(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $validated['file'] = $request->hasFile('file')
            ? $this->storeAttachment($request, $validated['tanggal'], $validated['judul'])
            : null;

        tugasModel::query()->create($validated);

        return redirect()->route('tugas')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function edit(string $id): View
    {
        $tugas = tugasModel::query()->with('guru')->findOrFail($id);

        return view('tugas.edit', compact('tugas'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $tugas = tugasModel::query()->findOrFail($id);
        $validated = $request->validate($this->rules());
        $oldFile = $tugas->file;

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

    public function delete(string $id): RedirectResponse
    {
        $tugas = tugasModel::query()->findOrFail($id);
        $file = $tugas->file;
        $tugas->delete();

        if ($file !== null) {
            Storage::disk('task_attachments')->delete($this->attachmentPath($file));
        }

        return redirect()->route('tugas')->with('success', 'Tugas berhasil dihapus.');
    }

    public function downloadFile(string $id): StreamedResponse
    {
        $tugas = tugasModel::query()->findOrFail($id);
        /** @var FilesystemAdapter $storage */
        $storage = Storage::disk('task_attachments');
        $path = $tugas->file === null ? null : $this->attachmentPath($tugas->file);
        abort_unless($path !== null && $storage->exists($path), 404);

        return $storage->download($path, basename($tugas->file));
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
            'id_guru' => [
                'required',
                'integer',
                Rule::exists('tb_guru', 'id')->whereNull('deleted_at'),
            ],
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
