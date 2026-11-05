<?php

namespace App\Http\Controllers;

use App\Imports\GuruImport;
use App\Models\guruModel;
use App\Models\jurusanModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class guruController extends Controller
{
    public function index(Request $request)
    {
        $query = guruModel::query()->with('jurusan');
        $search = trim((string) $request->input('search', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhereHas('jurusan', function ($jurusanQuery) use ($search) {
                        $jurusanQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('kode', 'like', "%{$search}%");
                    });
            });
        }

        $perPage = (int) $request->input('perPage', 15);
        if (! in_array($perPage, [15, 25, 50, 100], true)) {
            $perPage = 15;
        }

        $gurus = $query
            ->orderBy('id', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        if ($request->boolean('ajax')) {
            return response()->json([
                'rows' => view('guru.partials.guru_rows', compact('gurus'))->render(),
                'summary' => view('guru.partials.guru_summary', compact('gurus'))->render(),
                'pager' => view('guru.partials.guru_pager', compact('gurus'))->render(),
            ]);
        }

        return view('guru.index', compact('gurus'));
    }

    public function add()
    {
        $jurusans = jurusanModel::query()->orderBy('nama')->get();

        return view('guru.add', compact('jurusans'));
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'id_jurusan' => [
                'required',
                'integer',
                Rule::exists('tb_jurusan', 'id')->whereNull('deleted_at'),
            ],
        ]);

        guruModel::create($validated);

        return redirect()->route('guru')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $guru = guruModel::findOrFail($id);
        $jurusans = jurusanModel::query()->orderBy('nama')->get();

        return view('guru.edit', compact('guru', 'jurusans'));
    }

    public function update(Request $request, string $id)
    {
        $guru = guruModel::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'id_jurusan' => [
                'required',
                'integer',
                Rule::exists('tb_jurusan', 'id')->whereNull('deleted_at'),
            ],
        ]);

        $guru->update($validated);

        return redirect()->route('guru')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function delete(string $id)
    {
        $guru = guruModel::findOrFail($id);
        $guru->delete();

        return redirect()->route('guru')->with('success', 'Data guru berhasil dihapus.');
    }

    public function import()
    {
        return view('guru.import');
    }

    public function importStore(Request $request)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        Excel::import(new GuruImport, $validated['file']);

        return redirect()->route('guru')->with('success', 'Data guru berhasil diimport.');
    }
}
