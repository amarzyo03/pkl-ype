<?php

namespace App\Http\Controllers;

use App\Imports\DudiImport;
use App\Models\dudiModel;
use App\Models\guruModel;
use App\Models\jurusanModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class dudiController extends Controller
{
    public function index(Request $request)
    {
        $query = dudiModel::with(['jurusan', 'guru']);
        $search = trim((string) $request->input('search', ''));

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('telp', 'like', "%{$search}%")
                    ->orWhere('pic', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhereHas('jurusan', function ($jurusanQuery) use ($search) {
                        $jurusanQuery->where('kode', 'like', "%{$search}%")
                            ->orWhere('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('guru', function ($guruQuery) use ($search) {
                        $guruQuery->where('nama', 'like', "%{$search}%");
                    });
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
        $jurusans = jurusanModel::orderBy('nama')->get();
        $gurus = guruModel::orderBy('nama')->get();

        return view('dudi.add', compact('jurusans', 'gurus'));
    }

    public function save(Request $request)
    {
        $validated = $request->validate($this->rules());

        dudiModel::create($validated);

        return redirect()->route('dudi')->with('success', 'Data DUDI berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $dudi = dudiModel::findOrFail($id);
        $jurusans = jurusanModel::orderBy('nama')->get();
        $gurus = guruModel::orderBy('nama')->get();

        return view('dudi.edit', compact('dudi', 'jurusans', 'gurus'));
    }

    public function update(Request $request, string $id)
    {
        $dudi = dudiModel::findOrFail($id);
        $dudi->update($request->validate($this->rules()));

        return redirect()->route('dudi')->with('success', 'Data DUDI berhasil diperbarui.');
    }

    public function delete(string $id)
    {
        dudiModel::findOrFail($id)->delete();

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

    private function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'telp' => ['required', 'string', 'max:30'],
            'pic' => ['required', 'string', 'max:255'],
            'id_jurusan' => [
                'required',
                'integer',
                Rule::exists('tb_jurusan', 'id')->whereNull('deleted_at'),
            ],
            'id_guru' => [
                'required',
                'integer',
                Rule::exists('tb_guru', 'id')->whereNull('deleted_at'),
            ],
        ];
    }
}
