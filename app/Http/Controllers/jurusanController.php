<?php

namespace App\Http\Controllers;

use App\Imports\JurusanImport;
use App\Models\jurusanModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class jurusanController extends Controller
{
    public function index(Request $request)
    {
        $query = jurusanModel::query();

        $search = trim((string) $request->input('search', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('perPage', 15);
        if (!in_array($perPage, [15, 25, 50, 100], true)) {
            $perPage = 15;
        }

        $jurusans = $query
            ->orderBy('id', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        if ($request->boolean('ajax')) {
            return response()->json([
                'rows' => view('jurusan.partials.jurusan_rows', compact('jurusans'))->render(),
                'summary' => view('jurusan.partials.jurusan_summary', compact('jurusans'))->render(),
                'pager' => view('jurusan.partials.jurusan_pager', compact('jurusans'))->render(),
            ]);
        }

        return view('jurusan.index', compact('jurusans'));
    }

    public function add()
    {
        return view('jurusan.add');
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:255', 'unique:tb_jurusan,kode'],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        jurusanModel::create($validated);

        return redirect()->route('jurusan')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $jurusan = jurusanModel::findOrFail($id);

        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, string $id)
    {
        $jurusan = jurusanModel::findOrFail($id);

        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:255', Rule::unique('tb_jurusan', 'kode')->ignore($jurusan->id)],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $jurusan->update($validated);

        return redirect()->route('jurusan')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function delete(string $id)
    {
        $jurusan = jurusanModel::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('jurusan')->with('success', 'Jurusan berhasil dihapus.');
    }

    public function import()
    {
        return view('jurusan.import');
    }

    public function importStore(Request $request)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        Excel::import(new JurusanImport, $validated['file']);

        return redirect()->route('jurusan')->with('success', 'Data jurusan berhasil diimport.');
    }
}
