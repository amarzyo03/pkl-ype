<?php

use App\Imports\GuruImport;
use App\Models\guruModel;
use App\Models\jurusanModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin']);
    $this->jurusan = jurusanModel::query()->create([
        'kode' => 'GURU-RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);
    $this->jurusanLain = jurusanModel::query()->create([
        'kode' => 'GURU-TKJ',
        'nama' => 'Teknik Komputer dan Jaringan',
    ]);
});

it('can create, update, and delete guru data with its major', function () {
    $this->get(route('guru.add'))
        ->assertOk()
        ->assertSee('name="nama"', false)
        ->assertSee('name="id_jurusan"', false)
        ->assertDontSee('name="username"', false)
        ->assertDontSee('name="password"', false)
        ->assertSee('GURU-RPL - Rekayasa Perangkat Lunak')
        ->assertSee('Rekayasa Perangkat Lunak');

    $this->post(route('guru.save'), [
        'nama' => 'Budi Santoso',
        'id_jurusan' => $this->jurusan->id,
    ])->assertRedirect(route('guru'));

    $guru = guruModel::query()->where('nama', 'Budi Santoso')->firstOrFail();
    expect($guru->jurusan->nama)->toBe('Rekayasa Perangkat Lunak');

    $this->put(route('guru.update', $guru->id), [
        'nama' => 'Budi Santoso',
        'id_jurusan' => $this->jurusanLain->id,
    ])->assertRedirect(route('guru'));

    $this->get(route('guru.edit', $guru->id))
        ->assertOk()
        ->assertSee('GURU-TKJ - Teknik Komputer dan Jaringan');

    $guru->refresh();
    expect($guru->id_jurusan)->toBe($this->jurusanLain->id)
        ->and($guru->jurusan->nama)->toBe('Teknik Komputer dan Jaringan');

    $this->get(route('guru'))
        ->assertOk()
        ->assertSee('Budi Santoso')
        ->assertSee('Teknik Komputer dan Jaringan');
    $this->get(route('guru', ['search' => 'GURU-TKJ']))
        ->assertOk()
        ->assertSee('Budi Santoso')
        ->assertSee('Teknik Komputer dan Jaringan');

    $this->delete(route('guru.delete', $guru->id))->assertRedirect(route('guru'));
    $this->assertSoftDeleted('tb_guru', ['id' => $guru->id]);
});

it('requires a valid active major when creating and updating guru data', function () {
    $this->from(route('guru.add'))
        ->post(route('guru.save'), [
            'nama' => 'Guru Baru',
            'id_jurusan' => 999,
        ])
        ->assertRedirect(route('guru.add'))
        ->assertSessionHasErrors('id_jurusan');

    $guru = guruModel::query()->create([
        'nama' => 'Guru Lama',
        'id_jurusan' => $this->jurusan->id,
    ]);

    $this->from(route('guru.edit', $guru->id))
        ->put(route('guru.update', $guru->id), [
            'nama' => 'Guru Lama',
            'id_jurusan' => 999,
        ])
        ->assertRedirect(route('guru.edit', $guru->id))
        ->assertSessionHasErrors('id_jurusan');
});

it('imports guru names with their major using the major code', function () {
    (new GuruImport)->collection(collect([
        ['nama' => 'Guru Baru', 'kode_jurusan' => 'GURU-RPL'],
        ['nama' => 'Guru Baru', 'kode_jurusan' => 'GURU-TKJ'],
        ['nama' => 'Tanpa Jurusan', 'kode_jurusan' => 'UNKNOWN'],
    ]));

    expect(guruModel::query()->count())->toBe(1)
        ->and(guruModel::query()->where('nama', 'Guru Baru')->firstOrFail()->id_jurusan)
        ->toBe($this->jurusanLain->id);
});
