<?php

use App\Imports\DudiImport;
use App\Models\dudiModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create, update, and delete a dudi', function () {
    $response = $this->post(route('dudi.save'), [
        'nama' => 'PT Contoh Teknologi',
        'bidang_usaha' => 'Teknologi Informasi',
        'alamat' => 'Jl. Merdeka No. 10',
        'telepon' => '0215551234',
        'email' => 'info@contoh.test',
    ]);

    $response->assertRedirect(route('dudi'));

    $this->assertDatabaseHas('tb_dudi', [
        'nama' => 'PT Contoh Teknologi',
        'bidang_usaha' => 'Teknologi Informasi',
        'alamat' => 'Jl. Merdeka No. 10',
        'telepon' => '0215551234',
        'email' => 'info@contoh.test',
    ]);

    $dudi = dudiModel::where('nama', 'PT Contoh Teknologi')->firstOrFail();

    $this->put(route('dudi.update', $dudi->id), [
        'nama' => 'PT Contoh Digital',
        'bidang_usaha' => 'Konsultan IT',
        'alamat' => 'Jl. Industri No. 8',
        'telepon' => '0215559999',
        'email' => 'kontak@contoh.test',
    ])->assertRedirect(route('dudi'));

    $this->assertDatabaseHas('tb_dudi', [
        'id' => $dudi->id,
        'nama' => 'PT Contoh Digital',
        'bidang_usaha' => 'Konsultan IT',
    ]);

    $this->delete(route('dudi.delete', $dudi->id))->assertRedirect(route('dudi'));

    $this->assertSoftDeleted('tb_dudi', [
        'id' => $dudi->id,
    ]);
});

it('validates optional dudi email addresses', function () {
    $this->from(route('dudi.add'))
        ->post(route('dudi.save'), [
            'nama' => 'PT Contoh Teknologi',
            'email' => 'not-an-email',
        ])
        ->assertRedirect(route('dudi.add'))
        ->assertSessionHasErrors('email');

    $this->assertDatabaseCount('tb_dudi', 0);
});

it('imports dudi rows and updates matching names', function () {
    $import = new DudiImport;
    $import->collection(collect([
        [
            'nama' => 'PT Contoh Teknologi',
            'bidang_usaha' => 'Teknologi Informasi',
            'alamat' => 'Jl. Merdeka No. 10',
            'telepon' => '0215551234',
            'email' => 'info@contoh.test',
        ],
        ['nama' => '', 'bidang_usaha' => 'Baris tanpa nama'],
    ]));

    $import->collection(collect([
        [
            'nama' => 'PT Contoh Teknologi',
            'bidang_usaha' => 'Konsultan IT',
            'alamat' => 'Jl. Industri No. 8',
            'telepon' => '0215559999',
            'email' => 'kontak@contoh.test',
        ],
    ]));

    $this->assertDatabaseCount('tb_dudi', 1);
    $this->assertDatabaseHas('tb_dudi', [
        'nama' => 'PT Contoh Teknologi',
        'bidang_usaha' => 'Konsultan IT',
        'telepon' => '0215559999',
    ]);
});
