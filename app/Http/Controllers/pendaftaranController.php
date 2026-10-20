<?php

namespace App\Http\Controllers;

use App\Models\dudiModel;
use App\Models\pendaftaranModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class pendaftaranController extends Controller
{
    public function index(Request $request): View
    {
        $query = pendaftaranModel::query();
        $search = trim((string) $request->input('search', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('dudi', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('perPage', 15);
        if (! in_array($perPage, [15, 25, 50, 100], true)) {
            $perPage = 15;
        }

        $pendaftarans = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('pendaftaran.index', compact('pendaftarans'));
    }

    public function add(): View
    {
        $dudis = dudiModel::orderBy('nama')->get();

        return view('pendaftaran.add', compact('dudis'));
    }

    public function save(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'dudi' => ['required', 'string', Rule::exists('tb_dudi', 'nama')->whereNull('deleted_at')],
        ]);

        pendaftaranModel::create($validated);

        return redirect()->route('pendaftaran')->with('success', 'Pendaftaran berhasil ditambahkan.');
    }

    public function edit(string $id): View
    {
        $pendaftaran = pendaftaranModel::findOrFail($id);
        $dudis = dudiModel::orderBy('nama')->get();

        return view('pendaftaran.edit', compact('pendaftaran', 'dudis'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $pendaftaran = pendaftaranModel::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'dudi' => ['required', 'string', Rule::exists('tb_dudi', 'nama')->whereNull('deleted_at')],
        ]);

        $pendaftaran->update($validated);

        return redirect()->route('pendaftaran')->with('success', 'Pendaftaran berhasil diperbarui.');
    }

    public function delete(string $id): RedirectResponse
    {
        $pendaftaran = pendaftaranModel::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('pendaftaran')->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
