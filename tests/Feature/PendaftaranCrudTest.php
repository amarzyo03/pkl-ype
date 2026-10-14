<?php

use App\Models\dudiModel;
use App\Models\pendaftaranModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create, update, and soft delete a registration', function () {
    $dudi = dudiModel::create(['nama' => 'PT Contoh']);

    $this->get(route('pendaftaran.add'))
        ->assertOk()
        ->assertSee('Pendaftaran');

    $this->post(route('pendaftaran.save'), [
        'nama' => 'Budi Santoso',
        'dudi' => $dudi->nama,
    ])->assertRedirect(route('pendaftaran'));

    $pendaftaran = pendaftaranModel::firstOrFail();

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaran->id,
        'nama' => 'Budi Santoso',
        'dudi' => 'PT Contoh',
    ]);
    $this->get(route('pendaftaran'))
        ->assertOk()
        ->assertSee('Budi Santoso')
        ->assertSee('data-pendaftaran-sidebar-link')
        ->assertSee(route('pendaftaran'));

    $this->put(route('pendaftaran.update', $pendaftaran->id), [
        'nama' => 'Budi Santoso Updated',
        'dudi' => $dudi->nama,
    ])->assertRedirect(route('pendaftaran'));

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaran->id,
        'nama' => 'Budi Santoso Updated',
    ]);

    $this->delete(route('pendaftaran.delete', $pendaftaran->id))
        ->assertRedirect(route('pendaftaran'));

    $this->assertSoftDeleted('tb_pendaftaran', ['id' => $pendaftaran->id]);
});

it('requires a valid active DUDI for a registration', function () {
    $this->from(route('pendaftaran.add'))
        ->post(route('pendaftaran.save'), [
            'nama' => 'Budi Santoso',
            'dudi' => 'DUDI tidak terdaftar',
        ])
        ->assertRedirect(route('pendaftaran.add'))
        ->assertSessionHasErrors('dudi');
});
