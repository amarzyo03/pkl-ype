<?php

use App\Models\dudiModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('saves the submitted student and DUDI values in the registration table', function () {
    $dudi = dudiModel::query()->create([
        'nama' => 'PT Contoh',
        'alamat' => 'Jl. Contoh',
        'telp' => '08123456789',
        'pic' => 'Kontak',
        'id_jurusan' => 1,
        'id_guru' => 1,
    ]);

    $this->get(route('userSiswa.pendaftaran'))
        ->assertOk()
        ->assertSee(route('userSiswa.pendaftaran.attempt'), false)
        ->assertSee('name="nama"', false)
        ->assertSee('name="dudi"', false);

    $this->post(route('userSiswa.pendaftaran.attempt'), [
        'nama' => 'siswa1',
        'dudi' => $dudi->id,
    ])
        ->assertRedirect(route('userSiswa.pendaftaran'))
        ->assertSessionHas('success', 'Pendaftaran berhasil dikirim.');

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id_siswa' => 'siswa1',
        'id_dudi' => (string) $dudi->id,
        'status' => 'pending',
    ]);
});

it('rejects missing or deleted DUDI selections', function () {
    $dudi = dudiModel::query()->create([
        'nama' => 'PT Tidak Aktif',
        'alamat' => 'Jl. Contoh',
        'telp' => '08123456789',
        'pic' => 'Kontak',
        'id_jurusan' => 1,
        'id_guru' => 1,
    ]);
    $dudi->delete();

    $this->from(route('userSiswa.pendaftaran'))
        ->post(route('userSiswa.pendaftaran.attempt'), [
            'nama' => 'siswa1',
            'dudi' => $dudi->id,
        ])
        ->assertRedirect(route('userSiswa.pendaftaran'))
        ->assertSessionHasErrors('dudi');

    $this->assertDatabaseCount('tb_pendaftaran', 0);
});
