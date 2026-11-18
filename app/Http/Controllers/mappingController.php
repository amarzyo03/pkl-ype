<?php

namespace App\Http\Controllers;

use App\Models\guruMapelKelasModel;
use App\Models\guruModel;
use App\Models\kelasModel;
use App\Models\mapelModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class mappingController extends Controller
{
    public function index(Request $request)
    {
        $query = guruMapelKelasModel::query()->with(['guru', 'mapel', 'kelas']);
        $search = trim((string) $request->input('search', ''));

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->whereHas('guru', function ($guruQuery) use ($search) {
                    $guruQuery->where('nama', 'like', "%{$search}%");
                })->orWhereHas('mapel', function ($mapelQuery) use ($search) {
                    $mapelQuery->where('kode', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%");
                })->orWhereHas('kelas', function ($kelasQuery) use ($search) {
                    $kelasQuery->where('nama', 'like', "%{$search}%");
                });
            });
        }

        foreach (['id_guru', 'id_mapel', 'id_kelas'] as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->input($filter));
            }
        }

        $perPage = (int) $request->input('perPage', 15);
        if (! in_array($perPage, [15, 25, 50, 100], true)) {
            $perPage = 15;
        }

        $mappings = $query
            ->orderBy('id', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        $gurus = guruModel::withTrashed()->orderBy('nama')->get(['id', 'nama', 'deleted_at']);
        $mapels = mapelModel::withTrashed()->orderBy('nama')->get(['id', 'kode', 'nama', 'deleted_at']);
        $kelas = kelasModel::withTrashed()->orderBy('nama')->get(['id', 'nama', 'deleted_at']);

        return view('mapping.index', compact('mappings', 'gurus', 'mapels', 'kelas'));
    }

    public function create()
    {
        $gurus = guruModel::orderBy('nama')->get();
        $mapels = mapelModel::orderBy('nama')->get();
        $kelas = kelasModel::orderBy('nama')->get();

        return view('mapping.create', compact('gurus', 'mapels', 'kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules($request), $this->messages());

        try {
            guruMapelKelasModel::create($validated);
        } catch (QueryException $exception) {
            if (! $this->isUniqueConstraintViolation($exception)) {
                throw $exception;
            }

            return back()
                ->withInput()
                ->withErrors(['id_guru' => 'Mapping guru, mata pelajaran, dan kelas tersebut sudah terdaftar.']);
        }

        return redirect()->route('mapping.index')->with('success', 'Mapping pengajaran berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $mapping = guruMapelKelasModel::with(['guru', 'mapel', 'kelas'])->findOrFail($id);
        $gurus = guruModel::withTrashed()->orderBy('nama')->get();
        $mapels = mapelModel::withTrashed()->orderBy('nama')->get();
        $kelas = kelasModel::withTrashed()->orderBy('nama')->get();

        return view('mapping.edit', compact('mapping', 'gurus', 'mapels', 'kelas'));
    }

    public function update(Request $request, string $id)
    {
        $mapping = guruMapelKelasModel::findOrFail($id);
        $validated = $request->validate($this->rules($request, $mapping), $this->messages());

        try {
            $mapping->update($validated);
        } catch (QueryException $exception) {
            if (! $this->isUniqueConstraintViolation($exception)) {
                throw $exception;
            }

            return back()
                ->withInput()
                ->withErrors(['id_guru' => 'Mapping guru, mata pelajaran, dan kelas tersebut sudah terdaftar.']);
        }

        return redirect()->route('mapping.index')->with('success', 'Mapping pengajaran berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $mapping = guruMapelKelasModel::findOrFail($id);
        $mapping->delete();

        return redirect()->route('mapping.index')->with('success', 'Mapping pengajaran berhasil dihapus.');
    }

    private function rules(Request $request, ?guruMapelKelasModel $mapping = null): array
    {
        $uniqueCombination = Rule::unique('tr_guru_mapel_kelas', 'id_guru')
            ->where(fn ($query) => $query
                ->where('id_mapel', $request->input('id_mapel'))
                ->where('id_kelas', $request->input('id_kelas')));

        if ($mapping !== null) {
            $uniqueCombination->ignore($mapping->id);
        }

        return [
            'id_guru' => [
                'required',
                'integer',
                $this->masterExistsRule('tb_guru', 'id_guru', $request, $mapping),
                $uniqueCombination,
            ],
            'id_mapel' => [
                'required',
                'integer',
                $this->masterExistsRule('tb_mapel', 'id_mapel', $request, $mapping),
            ],
            'id_kelas' => [
                'required',
                'integer',
                $this->masterExistsRule('tb_kelas', 'id_kelas', $request, $mapping),
            ],
        ];
    }

    private function masterExistsRule(
        string $table,
        string $attribute,
        Request $request,
        ?guruMapelKelasModel $mapping
    ): Exists {
        $rule = Rule::exists($table, 'id');

        if ($mapping === null || (string) $request->input($attribute) !== (string) $mapping->{$attribute}) {
            $rule->whereNull('deleted_at');
        }

        return $rule;
    }

    private function messages(): array
    {
        return [
            'id_guru.required' => 'Guru wajib dipilih.',
            'id_guru.integer' => 'Guru yang dipilih tidak valid.',
            'id_guru.exists' => 'Guru yang dipilih tidak ditemukan atau sudah tidak aktif.',
            'id_guru.unique' => 'Mapping guru, mata pelajaran, dan kelas tersebut sudah terdaftar.',
            'id_mapel.required' => 'Mata pelajaran wajib dipilih.',
            'id_mapel.integer' => 'Mata pelajaran yang dipilih tidak valid.',
            'id_mapel.exists' => 'Mata pelajaran yang dipilih tidak ditemukan atau sudah tidak aktif.',
            'id_kelas.required' => 'Kelas wajib dipilih.',
            'id_kelas.integer' => 'Kelas yang dipilih tidak valid.',
            'id_kelas.exists' => 'Kelas yang dipilih tidak ditemukan atau sudah tidak aktif.',
        ];
    }

    private function isUniqueConstraintViolation(QueryException $exception): bool
    {
        $sqlState = (string) ($exception->errorInfo[0] ?? $exception->getCode());
        $driverCode = (int) ($exception->errorInfo[1] ?? 0);
        $message = strtolower($exception->getMessage());

        return $sqlState === '23505'
            || in_array($driverCode, [1062, 2601, 2627], true)
            || str_contains($message, 'unique constraint failed')
            || str_contains($message, 'duplicate entry')
            || str_contains($message, 'duplicate key');
    }
}
