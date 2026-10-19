<?php

use App\Models\dudiModel;
use App\Models\pendaftaranModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registers a student at an active DUDI and supports changing or cancelling the registration', function () {
    $dudi = dudiModel::query()->create(['nama' => 'PT Contoh']);
    $dudiLain = dudiModel::query()->create(['nama' => 'CV Contoh Lain']);

    $this->get(route('userSiswa.pendaftaran'))
        ->assertOk()
        ->assertSee($dudi->nama)
        ->assertSee($dudiLain->nama)
        ->assertSee('name="nama"', false)
        ->assertSee('name="dudi"', false);

    $this->post(route('userSiswa.pendaftaran.save'), [
        'nama' => 'Budi Santoso',
        'dudi' => $dudi->nama,
    ])->assertRedirect(route('userSiswa.pendaftaran'));

    $pendaftaran = pendaftaranModel::query()->firstOrFail();

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaran->id,
        'nama' => 'Budi Santoso',
        'dudi' => $dudi->nama,
    ]);

    $this->get(route('userSiswa.pendaftaran'))
        ->assertOk()
        ->assertSee('Anda telah mendaftar di tempat PKL')
        ->assertSee($dudi->nama)
        ->assertSee('Ubah')
        ->assertSee('Batalkan');

    $this->get(route('userSiswa.pendaftaran.edit'))
        ->assertOk()
        ->assertSee('value="Budi Santoso"', false)
        ->assertSee('Simpan perubahan');

    $this->put(route('userSiswa.pendaftaran.update'), [
        'nama' => 'Budi Santoso',
        'dudi' => $dudiLain->nama,
    ])->assertRedirect(route('userSiswa.pendaftaran'));

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaran->id,
        'dudi' => $dudiLain->nama,
    ]);

    $this->delete(route('userSiswa.pendaftaran.cancel'))
        ->assertRedirect(route('userSiswa.pendaftaran'));

    $this->assertSoftDeleted('tb_pendaftaran', ['id' => $pendaftaran->id]);

    $this->get(route('userSiswa.pendaftaran'))
        ->assertOk()
        ->assertSee('Pendaftaran tempat PKL berhasil dibatalkan.')
        ->assertSee('name="nama"', false)
        ->assertDontSee('Anda telah mendaftar di tempat PKL');
});

it('rejects a registration for a missing or deleted DUDI', function () {
    $deletedDudi = dudiModel::query()->create(['nama' => 'PT Tidak Aktif']);
    $deletedDudi->delete();

    $this->from(route('userSiswa.pendaftaran'))
        ->post(route('userSiswa.pendaftaran.save'), [
            'nama' => 'Budi Santoso',
            'dudi' => $deletedDudi->nama,
        ])
        ->assertRedirect(route('userSiswa.pendaftaran'))
        ->assertSessionHasErrors('dudi');

    $this->assertDatabaseCount('tb_pendaftaran', 0);
});

it('does not allow creating a second registration in the same session', function () {
    $dudi = dudiModel::query()->create(['nama' => 'PT Contoh']);

    $this->post(route('userSiswa.pendaftaran.save'), [
        'nama' => 'Budi Santoso',
        'dudi' => $dudi->nama,
    ])->assertRedirect(route('userSiswa.pendaftaran'));

    $this->post(route('userSiswa.pendaftaran.save'), [
        'nama' => 'Nama Lain',
        'dudi' => $dudi->nama,
    ])->assertRedirect(route('userSiswa.pendaftaran'))
        ->assertSessionHas('error');

    $this->assertDatabaseCount('tb_pendaftaran', 1);
});
