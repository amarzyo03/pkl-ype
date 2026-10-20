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
    // LOGIN
    public function login()
    {
        //
    }

    public function attemptLogin(Request $request)
    {
        //
    }

    public function logout(Request $request)
    {
        //
    }

    // WORKSPACE

    public function dashboard()
    {
        return view('userSiswa.dashboard');
    }

    public function absensi()
    {
        //
    }

    public function jurnal()
    {
        //
    }

    public function tugas()
    {
        //
    }

    // PENDAFTARAN
    public function pendaftaran()
    {
        $pendaftaran = pendaftaranModel::query()
            ->whereNotNull('id_siswa')
            ->where('id_siswa', '!=', '')
            ->whereHas('siswa')
            ->with('siswa.kelas', 'siswa.pendaftaran.dudi')
            ->latest('id')
            ->first();

        if ($pendaftaran !== null) {
            return view('userSiswa.pendaftaran.status', ['siswa' => $pendaftaran->siswa]);
        }

        $dudi = dudiModel::query()->get();

        return view('userSiswa.pendaftaran.pendaftaran', compact('dudi'));
    }

    public function attemptPendaftaran(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'integer', 'max:255'],
            'dudi' => ['required', 'integer'],
        ]);

        pendaftaranModel::create([
            'id_siswa' => $request->nama,
            'id_dudi' => $request->dudi,
            'status' => 'pending',
        ]);

        return redirect()->route('userSiswa.pendaftaran')->with('success', 'Pendaftaran berhasil dikirim.');
    }

    public function editPendaftaran(): View
    {
        $pendaftaran = pendaftaranModel::query()
            ->whereNotNull('id_siswa')
            ->where('id_siswa', '!=', '')
            ->whereHas('siswa')
            ->with('siswa')
            ->latest('id')
            ->firstOrFail();
        $dudi = dudiModel::query()->get();

        return view('userSiswa.pendaftaran.pendaftaran', compact('dudi', 'pendaftaran'));
    }

    public function updatePendaftaran(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'dudi' => [
                'required',
                'integer',
                Rule::exists('tb_dudi', 'id')->whereNull('deleted_at'),
            ],
        ]);

        $pendaftaran = pendaftaranModel::query()
            ->whereNotNull('id_siswa')
            ->where('id_siswa', '!=', '')
            ->whereHas('siswa')
            ->latest('id')
            ->firstOrFail();

        $pendaftaran->update([
            'id_dudi' => (string) $validated['dudi'],
        ]);

        return redirect()->route('userSiswa.pendaftaran')->with('success', 'Tempat PKL berhasil diperbarui.');
    }

    // PROFILE
    public function profile()
    {
        //
    }

    public function updateProfile(Request $request)
    {
        //
    }
}
