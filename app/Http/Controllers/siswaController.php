<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\siswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class siswaController extends Controller
{
    public function index(Request $request)
    {
        $query = siswaModel::query();

        $search = trim((string) $request->input('search', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nis', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('kelas', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $status = strtolower((string) $request->input('status', 'all'));
        if (in_array($status, ['active', 'inactive'], true)) {
            $query->where('status', $status);
        }

        $perPage = (int) $request->input('perPage', 15);
        if (!in_array($perPage, [15, 25, 50, 100], true)) {
            $perPage = 15;
        }

        $siswas = $query
            ->orderBy('id', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        if ($request->boolean('ajax')) {
            return response()->json([
                'rows' => view('siswa.partials.siswa_rows', compact('siswas'))->render(),
                'summary' => view('siswa.partials.siswa_summary', compact('siswas'))->render(),
                'pager' => view('siswa.partials.siswa_pager', compact('siswas'))->render(),
            ]);
        }

        return view('siswa.index', compact('siswas'));
    }

    public function add()
    {
        return view('siswa.add');
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:255', 'unique:tb_siswa,nis'],
            'nisn' => ['required', 'string', 'max:255', 'unique:tb_siswa,nisn'],
            'nama' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:tb_siswa,username'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        siswaModel::create($validated);

        return redirect()->route('siswa')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $siswa = siswaModel::findOrFail($id);

        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, string $id)
    {
        $siswa = siswaModel::findOrFail($id);

        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:255', Rule::unique('tb_siswa', 'nis')->ignore($siswa->id)],
            'nisn' => ['required', 'string', 'max:255', Rule::unique('tb_siswa', 'nisn')->ignore($siswa->id)],
            'nama' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('tb_siswa', 'username')->ignore($siswa->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $siswa->update($validated);

        return redirect()->route('siswa')->with('success', 'Siswa berhasil diperbarui.');
    }

    public function delete(string $id)
    {
        $siswa = siswaModel::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa')->with('success', 'Siswa berhasil dihapus.');
    }

    public function import()
    {
        return view('siswa.import');
    }

    public function importStore(Request $request)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        Excel::import(new SiswaImport, $validated['file']);

        return redirect()->route('siswa')->with('success', 'Data siswa berhasil diimport.');
    }
}
