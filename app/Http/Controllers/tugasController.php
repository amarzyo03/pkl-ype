<?php

namespace App\Http\Controllers;

use App\Models\tugasModel;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class tugasController extends Controller
{
    public function index(Request $request)
    {
        $query = tugasModel::query();
        $search = trim((string) $request->input('search', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('pengirim', 'like', "%{$search}%")
                    ->orWhere('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('perPage', 15);
        if (! in_array($perPage, [15, 25, 50, 100], true)) {
            $perPage = 15;
        }

        $tugases = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('tugas.index', compact('tugases'));
    }

    public function add()
    {
        return view('tugas.add');
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'pengirim' => ['required', 'string', 'max:255'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip,txt', 'max:20480'],
        ]);

        $validated['file'] = $request->file('file')->store('assets/static/tugas', 'task_attachments');
        tugasModel::create($validated);

        return redirect()->route('tugas')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $tugas = tugasModel::findOrFail($id);

        return view('tugas.edit', compact('tugas'));
    }

    public function update(Request $request, string $id)
    {
        $tugas = tugasModel::findOrFail($id);

        $validated = $request->validate([
            'pengirim' => ['required', 'string', 'max:255'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip,txt', 'max:20480'],
        ]);

        $oldFile = $tugas->file;
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('assets/static/tugas', 'task_attachments');
        }

        $tugas->update($validated);

        if (isset($validated['file'])) {
            Storage::disk('task_attachments')->delete($oldFile);
        }

        return redirect()->route('tugas')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function delete(string $id)
    {
        $tugas = tugasModel::findOrFail($id);
        $file = $tugas->file;
        $tugas->delete();
        Storage::disk('task_attachments')->delete($file);

        return redirect()->route('tugas')->with('success', 'Tugas berhasil dihapus.');
    }

    public function downloadFile(string $id)
    {
        $tugas = tugasModel::findOrFail($id);
        /** @var FilesystemAdapter $storage */
        $storage = Storage::disk('task_attachments');
        abort_unless($storage->exists($tugas->file), 404);

        return $storage->download($tugas->file);
    }
}
