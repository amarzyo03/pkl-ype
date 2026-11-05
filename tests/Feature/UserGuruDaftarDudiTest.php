<?php

use App\Models\dudiModel;
use App\Models\jurusanModel;
use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows only the signed-in teachers dudi with its related data', function () {
    $jurusan = jurusanModel::query()->create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);
    $guru = createGuruForTest(['nama' => 'Guru Pembimbing']);
    $otherGuru = createGuruForTest(['nama' => 'Guru Lain']);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru-daftar-dudi',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);
    dudiModel::query()->create([
        'nama' => 'PT Contoh Industri',
        'alamat' => 'Jl. Industri No. 1',
        'telp' => '021123456',
        'pic' => 'Budi Santoso',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $guru->id,
    ]);
    dudiModel::query()->create([
        'nama' => 'PT DUDI Lain',
        'alamat' => 'Jl. Lain No. 2',
        'telp' => '021654321',
        'pic' => 'Siti Aminah',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $otherGuru->id,
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->get(route('userGuru.daftarDudi'))
        ->assertOk()
        ->assertViewIs('userGuru.daftar-dudi.index')
        ->assertSee('PT CONTOH INDUSTRI')
        ->assertSee('Jl. Industri No. 1')
        ->assertSee('021123456')
        ->assertSee('Budi Santoso')
        ->assertSee('Rekayasa Perangkat Lunak')
        ->assertSee('Guru Pembimbing')
        ->assertDontSee('PT DUDI Lain');
});

it('shows an empty state when the teacher has no dudi', function () {
    $guru = createGuruForTest(['nama' => 'Guru Tanpa DUDI']);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru-tanpa-dudi',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->get(route('userGuru.daftarDudi'))
        ->assertOk()
        ->assertSee('Belum ada data DUDI untuk guru ini.');
});
