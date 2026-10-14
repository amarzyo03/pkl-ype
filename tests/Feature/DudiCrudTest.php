<?php

use App\Imports\DudiImport;
use App\Models\dudiModel;
use App\Models\guruModel;
use App\Models\jurusanModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

it('can create, update, and delete a dudi', function () {
    $jurusan = jurusanModel::create(['kode' => 'RPL', 'nama' => 'Rekayasa Perangkat Lunak']);
    $guru = guruModel::create([
        'nama' => 'Budi Santoso',
        'username' => 'budi',
        'password' => bcrypt('password'),
    ]);

    $this->get(route('dudi.add'))
        ->assertOk()
        ->assertSee('Rekayasa Perangkat Lunak')
        ->assertSee('Budi Santoso');

    $response = $this->post(route('dudi.save'), [
        'nama' => 'PT Contoh Teknologi',
        'alamat' => 'Jl. Merdeka No. 10',
        'telp' => '0215551234',
        'pic' => 'Budi',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $guru->id,
    ]);

    $response->assertRedirect(route('dudi'));

    $this->assertDatabaseHas('tb_dudi', [
        'nama' => 'PT Contoh Teknologi',
        'alamat' => 'Jl. Merdeka No. 10',
        'telp' => '0215551234',
        'pic' => 'Budi',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $guru->id,
    ]);

    $dudi = dudiModel::where('nama', 'PT Contoh Teknologi')->firstOrFail();

    $this->get(route('dudi'))
        ->assertOk()
        ->assertSee('data-dudi-sidebar-link')
        ->assertSee('PT Contoh Teknologi')
        ->assertSee('Rekayasa Perangkat Lunak')
        ->assertSee('Budi Santoso');

    $this->get(route('dudi.edit', $dudi->id))->assertOk();

    $this->put(route('dudi.update', $dudi->id), [
        'nama' => 'PT Contoh Digital',
        'alamat' => 'Jl. Industri No. 8',
        'telp' => '0215559999',
        'pic' => 'Siti',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $guru->id,
    ])->assertRedirect(route('dudi'));

    $this->assertDatabaseHas('tb_dudi', [
        'id' => $dudi->id,
        'nama' => 'PT Contoh Digital',
        'telp' => '0215559999',
        'pic' => 'Siti',
    ]);

    $this->delete(route('dudi.delete', $dudi->id))->assertRedirect(route('dudi'));

    $this->assertSoftDeleted('tb_dudi', [
        'id' => $dudi->id,
    ]);
});

it('rejects DUDI records that reference an unavailable guru', function () {
    $jurusan = jurusanModel::create(['kode' => 'RPL', 'nama' => 'Rekayasa Perangkat Lunak']);
    $guru = guruModel::create([
        'nama' => 'Budi Santoso',
        'username' => 'budi',
        'password' => bcrypt('password'),
    ]);

    $this->from(route('dudi.add'))
        ->post(route('dudi.save'), [
            'nama' => 'PT Contoh Teknologi',
            'alamat' => 'Jl. Merdeka No. 10',
            'telp' => '0215551234',
            'pic' => 'Budi',
            'id_jurusan' => $jurusan->id,
            'id_guru' => $guru->id + 1,
        ])
        ->assertRedirect(route('dudi.add'))
        ->assertSessionHasErrors('id_guru');

    $this->assertDatabaseCount('tb_dudi', 0);
});

it('imports dudi rows and updates matching names', function () {
    $this->get(route('dudi.import'))
        ->assertOk()
        ->assertSee('id_jurusan')
        ->assertSee('id_guru');

    $jurusan = jurusanModel::create(['kode' => 'RPL', 'nama' => 'Rekayasa Perangkat Lunak']);
    $guru = guruModel::create([
        'nama' => 'Budi Santoso',
        'username' => 'budi',
        'password' => bcrypt('password'),
    ]);

    $import = new DudiImport;
    $import->collection(collect([
        [
            'nama' => 'PT Contoh Teknologi',
            'alamat' => 'Jl. Merdeka No. 10',
            'telp' => '0215551234',
            'pic' => 'Budi',
            'id_jurusan' => $jurusan->id,
            'id_guru' => $guru->id,
        ],
        ['nama' => ''],
    ]));

    $import->collection(collect([
        [
            'nama' => 'PT Contoh Teknologi',
            'alamat' => 'Jl. Industri No. 8',
            'telp' => '0215559999',
            'pic' => 'Siti',
            'id_jurusan' => $jurusan->id,
            'id_guru' => $guru->id,
        ],
    ]));

    $this->assertDatabaseCount('tb_dudi', 1);
    $this->assertDatabaseHas('tb_dudi', [
        'nama' => 'PT Contoh Teknologi',
        'telp' => '0215559999',
        'pic' => 'Siti',
    ]);
});

it('rejects imports that reference a missing jurusan', function () {
    $guru = guruModel::create([
        'nama' => 'Budi Santoso',
        'username' => 'budi',
        'password' => bcrypt('password'),
    ]);

    expect(fn () => (new DudiImport)->collection(collect([
        [
            'nama' => 'PT Contoh Teknologi',
            'alamat' => 'Jl. Merdeka No. 10',
            'telp' => '0215551234',
            'pic' => 'Budi',
            'id_jurusan' => 999,
            'id_guru' => $guru->id,
        ],
    ])))->toThrow(ValidationException::class);

    $this->assertDatabaseCount('tb_dudi', 0);
});
