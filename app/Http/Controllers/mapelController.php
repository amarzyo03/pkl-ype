<?php

namespace App\Http\Controllers;

use App\Models\mapelModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class mapelController extends Controller
{
    public function index(Request $request)
    {
        $query = mapelModel::query();
        $search = trim((string) $request->input('search', ''));

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('kode', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('perPage', 15);
        if (! in_array($perPage, [15, 25, 50, 100], true)) {
            $perPage = 15;
        }

        $mapels = $query
            ->orderBy('id', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('mapel.index', compact('mapels'));
    }

    public function add()
    {
        return view('mapel.add');
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:255', 'unique:tb_mapel,kode'],
            'nama' => ['required', 'string', 'max:255'],
            'jenis' => ['required', Rule::in(['skk', 'produktif'])],
        ]);

        mapelModel::create($validated);

        return redirect()->route('mapel')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $mapel = mapelModel::findOrFail($id);

        return view('mapel.edit', compact('mapel'));
    }

    public function update(Request $request, string $id)
    {
        $mapel = mapelModel::findOrFail($id);

        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:255', Rule::unique('tb_mapel', 'kode')->ignore($mapel->id)],
            'nama' => ['required', 'string', 'max:255'],
            'jenis' => ['required', Rule::in(['skk', 'produktif'])],
        ]);

        $mapel->update($validated);

        return redirect()->route('mapel')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function delete(string $id)
    {
        $mapel = mapelModel::findOrFail($id);
        $mapel->delete();

        return redirect()->route('mapel')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
