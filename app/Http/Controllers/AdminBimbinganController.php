<?php

namespace App\Http\Controllers;

use App\Models\dudiModel;
use App\Models\siswaModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class AdminBimbinganController extends Controller
{
    public function daftarDudi(): View
    {
        $dudi = dudiModel::query()
            ->with(['jurusan', 'guru'])
            ->whereNotNull('id_guru')
            ->orderBy('nama')
            ->get();

        return view('userGuru.daftar-dudi.index', [
            'dudi' => $dudi,
            'isAdmin' => true,
        ]);
    }

    public function daftarSiswa(): View
    {
        $siswas = siswaModel::query()
            ->with(['kelas', 'pendaftaran.dudi.guru'])
            ->whereHas('pendaftaran.dudi', function (Builder $query): void {
                $query->whereNotNull('id_guru');
            })
            ->orderBy('nama')
            ->get();

        return view('userGuru.daftar-siswa.index', [
            'siswas' => $siswas,
            'isAdmin' => true,
        ]);
    }
}
