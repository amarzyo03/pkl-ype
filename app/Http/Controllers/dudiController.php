<?php

namespace App\Http\Controllers;

use App\Imports\DudiImport;
use App\Models\dudiModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class dudiController extends Controller
{
    public function index(Request $request)
    {
        $query = dudiModel::query();
        $search = trim((string) $request->input('search', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('bidang_usaha', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('telepon', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('perPage', 15);
        if (! in_array($perPage, [15, 25, 50, 100], true)) {
            $perPage = 15;
        }

        $dudis = $query
            ->orderBy('id', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        if ($request->boolean('ajax')) {
            return response()->json([
                'rows' => view('dudi.partials.dudi_rows', compact('dudis'))->render(),
                'summary' => view('dudi.partials.dudi_summary', compact('dudis'))->render(),
                'pager' => view('dudi.partials.dudi_pager', compact('dudis'))->render(),
            ]);
        }

        return view('dudi.index', compact('dudis'));
    }

    public function add()
    {
        return view('dudi.add');
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'bidang_usaha' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        dudiModel::create($validated);

        return redirect()->route('dudi')->with('success', 'Data DUDI berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $dudi = dudiModel::findOrFail($id);

        return view('dudi.edit', compact('dudi'));
    }

    public function update(Request $request, string $id)
    {
        $dudi = dudiModel::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'bidang_usaha' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $dudi->update($validated);

        return redirect()->route('dudi')->with('success', 'Data DUDI berhasil diperbarui.');
    }

    public function delete(string $id)
    {
        $dudi = dudiModel::findOrFail($id);
        $dudi->delete();

        return redirect()->route('dudi')->with('success', 'Data DUDI berhasil dihapus.');
    }

    public function import()
    {
        return view('dudi.import');
    }

    public function importStore(Request $request)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        Excel::import(new DudiImport, $validated['file']);

        return redirect()->route('dudi')->with('success', 'Data DUDI berhasil diimport.');
    }
}
