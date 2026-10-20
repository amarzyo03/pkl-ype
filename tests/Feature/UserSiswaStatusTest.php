<?php

use App\Models\dudiModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the registration view when no student has a registration', function () {
    $this->get(route('userSiswa.pendaftaran'))
        ->assertOk()
        ->assertSee(route('userSiswa.pendaftaran.attempt'), false)
        ->assertSee('name="nama"', false)
        ->assertSee('name="dudi"', false);
});

it('shows the status view for the student linked to a registration with a filled student id', function () {
    $siswa = siswaModel::query()->create([
        'nis' => '1001',
        'nisn' => '2001',
        'nama' => 'Siswa Terdaftar',
        'id_kelas' => 1,
        'username' => 'siswa-terdaftar',
        'password' => 'secret',
    ]);

    pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswa->id,
        'id_dudi' => '1',
        'status' => 'diterima',
    ]);

    $this->get(route('userSiswa.pendaftaran'))
        ->assertOk()
        ->assertSee('Siswa Terdaftar')
        ->assertSee(route('userSiswa.pendaftaran.edit'), false)
        ->assertSee('Ubah DUDI')
        ->assertSee('DITERIMA')
        ->assertDontSee('<table', false);
});

it('allows changing the DUDI for an existing registration', function () {
    $siswa = siswaModel::query()->create([
        'nis' => '1002',
        'nisn' => '2002',
        'nama' => 'Siswa Edit',
        'id_kelas' => 1,
        'username' => 'siswa-edit',
        'password' => 'secret',
    ]);
    $dudiAwal = dudiModel::query()->create([
        'nama' => 'PT Lama',
        'alamat' => 'Jl. Lama',
        'telp' => '08123456789',
        'pic' => 'Kontak Lama',
        'id_jurusan' => 1,
        'id_guru' => 1,
    ]);
    $dudiBaru = dudiModel::query()->create([
        'nama' => 'PT Baru',
        'alamat' => 'Jl. Baru',
        'telp' => '08123456780',
        'pic' => 'Kontak Baru',
        'id_jurusan' => 1,
        'id_guru' => 1,
    ]);
    $pendaftaran = pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswa->id,
        'id_dudi' => (string) $dudiAwal->id,
        'status' => 'pending',
    ]);

    $this->get(route('userSiswa.pendaftaran.edit'))
        ->assertOk()
        ->assertSee('Ubah Tempat PKL')
        ->assertSee('value="'.$dudiAwal->id.'" selected', false)
        ->assertSee('Simpan Perubahan');

    $this->put(route('userSiswa.pendaftaran.update'), [
        'dudi' => $dudiBaru->id,
    ])
        ->assertRedirect(route('userSiswa.pendaftaran'))
        ->assertSessionHas('success', 'Tempat PKL berhasil diperbarui.');

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaran->id,
        'id_siswa' => (string) $siswa->id,
        'id_dudi' => (string) $dudiBaru->id,
    ]);
    $this->assertDatabaseCount('tb_pendaftaran', 1);

    $this->from(route('userSiswa.pendaftaran.edit'))
        ->put(route('userSiswa.pendaftaran.update'), [
            'dudi' => 999999,
        ])
        ->assertRedirect(route('userSiswa.pendaftaran.edit'))
        ->assertSessionHasErrors('dudi');

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaran->id,
        'id_dudi' => (string) $dudiBaru->id,
    ]);
});
