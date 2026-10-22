<?php

namespace App\Http\Controllers;

use App\Models\dudiModel;
use App\Models\pendaftaranModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class pendaftaranController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $pendaftarans = pendaftaranModel::query()
            ->with(['siswa', 'dudi'])
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('id', 'like', "%{$search}%")
                        ->orWhereHas('siswa', function (Builder $siswaQuery) use ($search): void {
                            $siswaQuery->where('nama', 'like', "%{$search}%")
                                ->orWhere('nis', 'like', "%{$search}%")
                                ->orWhere('nisn', 'like', "%{$search}%");
                        })
                        ->orWhereHas('dudi', function (Builder $dudiQuery) use ($search): void {
                            $dudiQuery->where('nama', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('pendaftaran.index', compact('pendaftarans', 'search'));
    }

    public function add(): View
    {
        $dudis = dudiModel::query()->orderBy('nama')->get();

        return view('pendaftaran.add', compact('dudis'));
    }

    public function save(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        pendaftaranModel::query()->create([
            ...$validated,
            'status' => 'pending',
        ]);

        return redirect()->route('pendaftaran')->with('success', 'Pendaftaran berhasil ditambahkan.');
    }

    public function edit(string $id): View
    {
        $pendaftaran = pendaftaranModel::query()->findOrFail($id);
        $dudis = dudiModel::query()->orderBy('nama')->get();

        return view('pendaftaran.edit', compact('pendaftaran', 'dudis'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $pendaftaran = pendaftaranModel::query()->findOrFail($id);
        $pendaftaran->update($request->validate($this->rules($pendaftaran)));

        return redirect()->route('pendaftaran')->with('success', 'Pendaftaran berhasil diperbarui.');
    }

    public function delete(string $id): RedirectResponse
    {
        pendaftaranModel::query()->findOrFail($id)->delete();

        return redirect()->route('pendaftaran')->with('success', 'Pendaftaran berhasil dihapus.');
    }

    public function updateStatus(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'disetujui', 'ditolak'])],
        ]);

        $pendaftaran = pendaftaranModel::query()->findOrFail($id);
        $targetStatus = $validated['status'];
        $allowedCurrentStatuses = $targetStatus === 'pending'
            ? ['disetujui', 'ditolak']
            : ['pending'];

        if (! in_array($pendaftaran->status, $allowedCurrentStatuses, true)) {
            return redirect()->route('pendaftaran')
                ->with('error', 'Status pendaftaran sudah berubah. Muat ulang halaman dan coba lagi.');
        }

        $updated = pendaftaranModel::query()
            ->whereKey($pendaftaran->getKey())
            ->whereIn('status', $allowedCurrentStatuses)
            ->update($validated);

        if ($updated === 0) {
            return redirect()->route('pendaftaran')
                ->with('error', 'Status pendaftaran sudah berubah. Muat ulang halaman dan coba lagi.');
        }

        $message = $targetStatus === 'pending'
            ? 'Keputusan pendaftaran berhasil dibatalkan. Status kembali menjadi pending.'
            : "Pendaftaran berhasil {$targetStatus}.";

        return redirect()->route('pendaftaran')->with('success', $message);
    }

    private function rules(?pendaftaranModel $current = null): array
    {
        $uniqueStudent = Rule::unique('tb_pendaftaran', 'id_siswa');

        if ($current !== null) {
            $uniqueStudent->ignore($current->getKey());
        }

        return [
            'id_siswa' => [
                'required',
                'integer',
                Rule::exists('tb_siswa', 'id')->whereNull('deleted_at'),
                $uniqueStudent,
            ],
            'id_dudi' => [
                'required',
                'integer',
                Rule::exists('tb_dudi', 'id')->whereNull('deleted_at'),
            ],
        ];
    }
}
