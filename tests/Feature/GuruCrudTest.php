<?php

use App\Imports\GuruImport;
use App\Models\guruModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin']);
});

it('can create, update, and delete guru data without a jurusan field', function () {
    $this->get(route('guru.add'))
        ->assertOk()
        ->assertSee('name="nama"', false)
        ->assertDontSee('name="id_jurusan"', false)
        ->assertDontSee('name="username"', false)
        ->assertDontSee('name="password"', false);

    $this->post(route('guru.save'), [
        'nama' => 'Budi Santoso',
    ])->assertRedirect(route('guru'));

    $guru = guruModel::query()->where('nama', 'Budi Santoso')->firstOrFail();
    expect($guru->nama)->toBe('Budi Santoso');

    $this->put(route('guru.update', $guru->id), [
        'nama' => 'Budi Santoso Baru',
    ])->assertRedirect(route('guru'));

    $this->get(route('guru.edit', $guru->id))
        ->assertOk()
        ->assertSee('Budi Santoso Baru');

    $guru->refresh();
    expect($guru->nama)->toBe('Budi Santoso Baru');

    $this->get(route('guru'))
        ->assertOk()
        ->assertSee('Budi Santoso Baru');
    $this->get(route('guru', ['search' => 'Budi']))
        ->assertOk()
        ->assertSee('Budi Santoso Baru');

    $this->delete(route('guru.delete', $guru->id))->assertRedirect(route('guru'));
    $this->assertSoftDeleted('tb_guru', ['id' => $guru->id]);
});

it('shows legacy guru rows with an empty deleted_at value after normalization', function () {
    DB::table('tb_guru')->insert([
        'nama' => 'Guru Data Lama',
        'deleted_at' => '',
    ]);

    $migration = require database_path('migrations/2026_11_17_082000_normalize_empty_tb_guru_deleted_at.php');
    $migration->up();

    $this->get(route('guru'))
        ->assertOk()
        ->assertSee('Guru Data Lama');
});

it('imports guru names without needing a jurusan', function () {
    (new GuruImport)->collection(collect([
        ['nama' => 'Guru Baru'],
        ['nama' => 'Guru Baru'],
        ['nama' => 'Guru Lain'],
    ]));

    expect(guruModel::query()->count())->toBe(2)
        ->and(guruModel::query()->where('nama', 'Guru Baru')->count())->toBe(1)
        ->and(guruModel::query()->where('nama', 'Guru Lain')->exists())->toBeTrue();
});
