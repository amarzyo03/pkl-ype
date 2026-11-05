<?php

use App\Models\dudiModel;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists approved students assigned to the signed-in students dudi', function () {
    $jurusan = jurusanModel::query()->create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);
    $kelas = kelasModel::query()->create([
        'nama' => 'XI RPL 1',
        'id_jurusan' => $jurusan->id,
    ]);
    $guru = createGuruForTest(['nama' => 'Guru Pembimbing']);
    $dudi = dudiModel::query()->create([
        'nama' => 'PT Mitra Siswa',
        'alamat' => 'Jl. Industri No. 1',
        'telp' => '021123456',
        'pic' => 'Budi Santoso',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $guru->id,
    ]);
    $otherDudi = dudiModel::query()->create([
        'nama' => 'PT Mitra Lain',
        'alamat' => 'Jl. Industri No. 2',
        'telp' => '021654321',
        'pic' => 'Siti Aminah',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $guru->id,
    ]);

    $siswaLogin = siswaModel::query()->create([
        'nis' => '12345',
        'nisn' => '9876543210',
        'nama' => 'Siswa Login',
        'id_kelas' => $kelas->id,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $siswaLogin->id,
        'username' => 'siswa-daftar',
        'password' => 'password',
        'role' => 'siswa',
        'status' => 'active',
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswaLogin->id,
        'id_dudi' => (string) $dudi->id,
        'status' => 'disetujui',
    ]);

    $temanSiswa = siswaModel::query()->create([
        'nis' => '12346',
        'nisn' => '9876543211',
        'nama' => 'Teman Satu DUDI',
        'id_kelas' => $kelas->id,
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $temanSiswa->id,
        'id_dudi' => (string) $dudi->id,
        'status' => 'disetujui',
    ]);

    $siswaDudiLain = siswaModel::query()->create([
        'nis' => '12347',
        'nisn' => '9876543212',
        'nama' => 'Siswa DUDI Lain',
        'id_kelas' => $kelas->id,
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswaDudiLain->id,
        'id_dudi' => (string) $otherDudi->id,
        'status' => 'disetujui',
    ]);

    $siswaPending = siswaModel::query()->create([
        'nis' => '12348',
        'nisn' => '9876543213',
        'nama' => 'Siswa Menunggu',
        'id_kelas' => $kelas->id,
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswaPending->id,
        'id_dudi' => (string) $dudi->id,
        'status' => 'pending',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'siswa'])
        ->get(route('userSiswa.daftarSiswa'))
        ->assertOk()
        ->assertViewIs('userSiswa.daftar-siswa.index')
        ->assertSee('Siswa Login')
        ->assertSee('Teman Satu DUDI')
        ->assertSee('XI RPL 1')
        ->assertSee('PT Mitra Siswa')
        ->assertDontSee('Siswa DUDI Lain')
        ->assertDontSee('Siswa Menunggu');
});

it('shows an empty state when the signed-in student has no approved dudi', function () {
    $jurusan = jurusanModel::query()->create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);
    $kelas = kelasModel::query()->create([
        'nama' => 'XI RPL 1',
        'id_jurusan' => $jurusan->id,
    ]);
    $siswa = siswaModel::query()->create([
        'nis' => '22345',
        'nisn' => '8876543210',
        'nama' => 'Siswa Belum Disetujui',
        'id_kelas' => $kelas->id,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $siswa->id,
        'username' => 'siswa-pending',
        'password' => 'password',
        'role' => 'siswa',
        'status' => 'active',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'siswa'])
        ->get(route('userSiswa.daftarSiswa'))
        ->assertOk()
        ->assertSee('Belum ada siswa yang disetujui pada DUDI yang sama.');
});
