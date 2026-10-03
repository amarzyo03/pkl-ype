<?php

namespace App\Http\Controllers;

use App\Imports\KelasImport;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class kelasController extends Controller
{
    public function index(Request $request)
    {
        $query = kelasModel::query()->with('jurusan');

        $search = trim((string) $request->input('search', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('tb_kelas.nama', 'like', "%{$search}%")
                    ->orWhere('tb_kelas.id', 'like', "%{$search}%")
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

        $kelas = $query
            ->orderBy('tb_kelas.id', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        if ($request->boolean('ajax')) {
            return response()->json([
                'rows' => view('kelas.partials.kelas_rows', compact('kelas'))->render(),
                'summary' => view('kelas.partials.kelas_summary', compact('kelas'))->render(),
                'pager' => view('kelas.partials.kelas_pager', compact('kelas'))->render(),
            ]);
        }

        return view('kelas.index', compact('kelas'));
    }

    public function add()
    {
        $jurusans = jurusanModel::orderBy('nama')->get();

        return view('kelas.add', compact('jurusans'));
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'tingkat' => ['required', 'in:X,XI,XII'],
            'id_jurusan' => ['required', 'exists:tb_jurusan,id'],
            'nomor' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $jurusan = jurusanModel::findOrFail($validated['id_jurusan']);
        $validated['nama'] = sprintf('%s %s %d', $validated['tingkat'], $jurusan->kode, $validated['nomor']);

        unset($validated['tingkat'], $validated['nomor']);

        kelasModel::create($validated);

        return redirect()->route('kelas')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $kelas = kelasModel::with('jurusan')->findOrFail($id);
        $jurusans = jurusanModel::orderBy('nama')->get();

        $parts = preg_split('/\s+/', trim($kelas->nama));
        $tingkat = $parts[0] ?? '';
        $nomor = (int) ($parts[count($parts) - 1] ?? 0);

        return view('kelas.edit', compact('kelas', 'jurusans', 'tingkat', 'nomor'));
    }

    public function update(Request $request, string $id)
    {
        $kelas = kelasModel::findOrFail($id);

        $validated = $request->validate([
            'tingkat' => ['required', 'in:X,XI,XII'],
            'id_jurusan' => ['required', 'exists:tb_jurusan,id'],
            'nomor' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $jurusan = jurusanModel::findOrFail($validated['id_jurusan']);
        $validated['nama'] = sprintf('%s %s %d', $validated['tingkat'], $jurusan->kode, $validated['nomor']);

        unset($validated['tingkat'], $validated['nomor']);

        $kelas->update($validated);

        return redirect()->route('kelas')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function delete(string $id)
    {
        $kelas = kelasModel::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas')->with('success', 'Kelas berhasil dihapus.');
    }

    public function import()
    {
        return view('kelas.import');
    }

    public function importStore(Request $request)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        Excel::import(new KelasImport, $validated['file']);

        return redirect()->route('kelas')->with('success', 'Data kelas berhasil diimport.');
    }
}
