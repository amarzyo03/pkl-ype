<?php

use App\Models\dudiModel;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows only students registered with the current teachers dudi', function () {
    $jurusan = jurusanModel::query()->create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);
    $kelas = kelasModel::query()->create([
        'nama' => 'XI RPL 1',
        'id_jurusan' => $jurusan->id,
    ]);
    $guru = createGuruForTest(['nama' => 'Guru Pembimbing']);
    $otherGuru = createGuruForTest(['nama' => 'Guru Lain']);
    $dudi = dudiModel::query()->create([
        'nama' => 'PT Mitra Guru',
        'alamat' => 'Jl. Industri No. 1',
        'telp' => '021123456',
        'pic' => 'Budi Santoso',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $guru->id,
    ]);
    $otherDudi = dudiModel::query()->create([
        'nama' => 'PT Mitra Guru Lain',
        'alamat' => 'Jl. Industri No. 2',
        'telp' => '021654321',
        'pic' => 'Siti Aminah',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $otherGuru->id,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru-daftar-siswa',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);
    $siswa = siswaModel::query()->create([
        'nis' => '12345',
        'nisn' => '9876543210',
        'nama' => 'Siswa Bimbingan',
        'id_kelas' => $kelas->id,
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswa->id,
        'id_dudi' => (string) $dudi->id,
        'status' => 'disetujui',
    ]);
    $otherSiswa = siswaModel::query()->create([
        'nis' => '54321',
        'nisn' => '0123456789',
        'nama' => 'Siswa Guru Lain',
        'id_kelas' => $kelas->id,
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $otherSiswa->id,
        'id_dudi' => (string) $otherDudi->id,
        'status' => 'disetujui',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->get(route('userGuru.daftarSiswa'))
        ->assertOk()
        ->assertViewIs('userGuru.daftar-siswa.index')
        ->assertSee('Siswa Bimbingan')
        ->assertSee('12345')
        ->assertSee('9876543210')
        ->assertSee('XI RPL 1')
        ->assertSee('PT Mitra Guru')
        ->assertSee('Disetujui')
        ->assertDontSee('Siswa Guru Lain')
        ->assertDontSee('PT Mitra Guru Lain');
});

it('shows an empty state when no students are registered with the teachers dudi', function () {
    $guru = createGuruForTest(['nama' => 'Guru Tanpa Siswa']);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru-tanpa-siswa',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->get(route('userGuru.daftarSiswa'))
        ->assertOk()
        ->assertSee('Belum ada siswa yang terdaftar pada DUDI bimbingan Anda.');
});
