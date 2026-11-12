<?php

namespace App\Http\Controllers;

use App\Models\dudiModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class pendaftaranController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $search = trim((string) $request->query('search', ''));

        $perPage = (int) $request->query('perPage', 15);

        if (! in_array($perPage, [15, 25, 50, 100], true)) {
            $perPage = 15;
        }

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
            ->paginate($perPage)
            ->appends($request->query());

        if ($request->boolean('ajax')) {
            return response()->json([
                'rows' => view('pendaftaran.partials.pendaftaran_rows', compact('pendaftarans'))->render(),
                'summary' => view('pendaftaran.partials.pendaftaran_summary', compact('pendaftarans'))->render(),
                'pager' => view('pendaftaran.partials.pendaftaran_pager', compact('pendaftarans'))->render(),
            ]);
        }

        return view('pendaftaran.index', compact('pendaftarans', 'search'));
    }

    public function add(): View
    {
        $dudis = dudiModel::query()->orderBy('nama')->get();
        $siswas = siswaModel::query()
            ->whereDoesntHave('pendaftaran', fn (Builder $query) => $query->withTrashed())
            ->orderBy('nama')
            ->get();

        return view('pendaftaran.add', compact('dudis', 'siswas'));
    }

    public function save(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        pendaftaranModel::query()->create($validated);

        return redirect()->route('pendaftaran')->with('success', 'Pendaftaran berhasil ditambahkan.');
    }

    public function edit(string $id): View
    {
        $pendaftaran = pendaftaranModel::query()->findOrFail($id);
        $dudis = dudiModel::query()->orderBy('nama')->get();
        $siswas = siswaModel::query()
            ->where(function (Builder $query) use ($pendaftaran): void {
                $query->whereDoesntHave('pendaftaran', fn (Builder $query) => $query->withTrashed());

                if ($pendaftaran->siswa !== null) {
                    $query->orWhereKey($pendaftaran->id_siswa);
                }
            })
            ->orderBy('nama')
            ->get();

        return view('pendaftaran.edit', compact('pendaftaran', 'dudis', 'siswas'));
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

    public function updateSelectedStatuses(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pendaftaran_ids' => ['required', 'array', 'min:1'],
            'pendaftaran_ids.*' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('tb_pendaftaran', 'id')->whereNull('deleted_at'),
            ],
            'status' => ['required', Rule::in(['pending', 'disetujui', 'ditolak'])],
        ]);

        $updated = DB::transaction(function () use ($validated): bool {
            $pendaftaranIds = $validated['pendaftaran_ids'];
            $pendaftarans = pendaftaranModel::query()
                ->whereIn('id', $pendaftaranIds)
                ->lockForUpdate()
                ->get(['id']);

            if ($pendaftarans->count() !== count($pendaftaranIds)) {
                return false;
            }

            pendaftaranModel::query()
                ->whereIn('id', $pendaftaranIds)
                ->update(['status' => $validated['status']]);

            return true;
        });

        if (! $updated) {
            return redirect()->route('pendaftaran')
                ->with('error', 'Data pendaftaran berubah. Muat ulang halaman dan coba lagi.');
        }

        return redirect()->route('pendaftaran')
            ->with('success', 'Status pendaftaran yang dipilih berhasil diperbarui.');
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
            'status' => ['required', Rule::in(['pending', 'disetujui', 'ditolak'])],
        ];
    }
}
