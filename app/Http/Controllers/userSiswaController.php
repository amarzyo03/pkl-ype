<?php

namespace App\Http\Controllers;

use App\Models\dudiModel;
use App\Models\pendaftaranModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class userSiswaController extends Controller
{
    private const SESSION_PENDAFTARAN_KEY = 'userSiswa.pendaftaran_id';

    public function showLogin(): View
    {
        return view('userSiswa.login');
    }

    public function dashboard(): View
    {
        return view('userSiswa.dashboard');
    }

    public function pendaftaran(Request $request): View
    {
        $pendaftaran = $this->getPendaftaranFromSession($request);
        $dudis = dudiModel::query()->orderBy('nama')->get();
        $isEditing = false;

        return view('userSiswa.pendaftaran', compact('dudis', 'isEditing', 'pendaftaran'));
    }

    public function ubahPendaftaran(Request $request): View|RedirectResponse
    {
        $pendaftaran = $this->getPendaftaranFromSession($request);

        if ($pendaftaran === null) {
            return redirect()->route('userSiswa.pendaftaran');
        }

        $dudis = dudiModel::query()->orderBy('nama')->get();
        $isEditing = true;

        return view('userSiswa.pendaftaran', compact('dudis', 'isEditing', 'pendaftaran'));
    }

    public function daftarPkl(Request $request): RedirectResponse
    {
        if ($this->getPendaftaranFromSession($request) !== null) {
            return redirect()->route('userSiswa.pendaftaran')
                ->with('error', 'Anda sudah memiliki pendaftaran tempat PKL.');
        }

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'dudi' => ['required', 'string', Rule::exists('tb_dudi', 'nama')->whereNull('deleted_at')],
        ]);

        $pendaftaran = pendaftaranModel::query()->create($validated);
        $request->session()->put(self::SESSION_PENDAFTARAN_KEY, $pendaftaran->id);

        return redirect()->route('userSiswa.pendaftaran');
    }

    public function updatePendaftaran(Request $request): RedirectResponse
    {
        $pendaftaran = $this->getPendaftaranFromSession($request);

        if ($pendaftaran === null) {
            return redirect()->route('userSiswa.pendaftaran')
                ->with('error', 'Pendaftaran tempat PKL tidak ditemukan.');
        }

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'dudi' => ['required', 'string', Rule::exists('tb_dudi', 'nama')->whereNull('deleted_at')],
        ]);

        $pendaftaran->update($validated);

        return redirect()->route('userSiswa.pendaftaran');
    }

    public function batalkanPendaftaran(Request $request): RedirectResponse
    {
        $pendaftaran = $this->getPendaftaranFromSession($request);

        if ($pendaftaran !== null) {
            $pendaftaran->delete();
            $request->session()->forget(self::SESSION_PENDAFTARAN_KEY);
        }

        return redirect()->route('userSiswa.pendaftaran')
            ->with('success', 'Pendaftaran tempat PKL berhasil dibatalkan.');
    }

    private function getPendaftaranFromSession(Request $request): ?pendaftaranModel
    {
        $pendaftaranId = $request->session()->get(self::SESSION_PENDAFTARAN_KEY);

        if ($pendaftaranId === null) {
            return null;
        }

        $pendaftaran = pendaftaranModel::query()->find($pendaftaranId);

        if ($pendaftaran === null) {
            $request->session()->forget(self::SESSION_PENDAFTARAN_KEY);
        }

        return $pendaftaran;
    }
}
