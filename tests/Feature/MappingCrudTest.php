<?php

use App\Models\guruMapelKelasModel;
use App\Models\guruModel;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use App\Models\mapelModel;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin']);
});

it('can create, view, update, and delete a guru mapel kelas mapping', function () {
    $guru = guruModel::create(['nama' => 'Budi Santoso']);
    $mapel = mapelModel::create([
        'kode' => 'if',
        'nama' => 'Informatika',
        'jenis' => 'produktif',
    ]);
    $jurusan = jurusanModel::create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);
    $kelas = kelasModel::create([
        'nama' => 'X RPL 1',
        'id_jurusan' => $jurusan->id,
    ]);
    $kelasBaru = kelasModel::create([
        'nama' => 'X RPL 2',
        'id_jurusan' => $jurusan->id,
    ]);

    $this->get(route('mapping.create'))
        ->assertOk()
        ->assertSee('Budi Santoso')
        ->assertSee('Informatika')
        ->assertSee('X RPL 1');

    $this->post(route('mapping.store'), [
        'id_guru' => $guru->id,
        'id_mapel' => $mapel->id,
        'id_kelas' => $kelas->id,
    ])->assertRedirect(route('mapping.index'));

    $mapping = guruMapelKelasModel::query()->firstOrFail();

    $this->get(route('mapping.index'))
        ->assertOk()
        ->assertSee('Budi Santoso')
        ->assertSee('Informatika')
        ->assertSee('X RPL 1');
    $this->get(route('mapping.index', ['search' => 'Budi', 'id_guru' => $guru->id]))
        ->assertOk()
        ->assertSee('X RPL 1');

    $editResponse = $this->get(route('mapping.edit', $mapping->id))
        ->assertOk();

    expect(preg_match('/<option value="'.$kelas->id.'"\\s+selected>/', $editResponse->getContent()))->toBe(1);

    $this->put(route('mapping.update', $mapping->id), [
        'id_guru' => $guru->id,
        'id_mapel' => $mapel->id,
        'id_kelas' => $kelasBaru->id,
    ])->assertRedirect(route('mapping.index'));

    $this->assertDatabaseHas('tr_guru_mapel_kelas', [
        'id' => $mapping->id,
        'id_kelas' => $kelasBaru->id,
    ]);

    $this->delete(route('mapping.destroy', $mapping->id))->assertRedirect(route('mapping.index'));

    $this->assertSoftDeleted('tr_guru_mapel_kelas', ['id' => $mapping->id]);
    $this->assertDatabaseHas('tb_guru', ['id' => $guru->id, 'deleted_at' => null]);
    $this->assertDatabaseHas('tb_mapel', ['id' => $mapel->id, 'deleted_at' => null]);
    $this->assertDatabaseHas('tb_kelas', ['id' => $kelas->id, 'deleted_at' => null]);
});

it('validates required master records and rejects a duplicate mapping', function () {
    $guru = guruModel::create(['nama' => 'Siti Aminah']);
    $mapel = mapelModel::create([
        'kode' => 'mtk',
        'nama' => 'Matematika',
        'jenis' => 'skk',
    ]);
    $jurusan = jurusanModel::create([
        'kode' => 'AKL',
        'nama' => 'Akuntansi',
    ]);
    $kelas = kelasModel::create([
        'nama' => 'X AKL 1',
        'id_jurusan' => $jurusan->id,
    ]);

    $this->post(route('mapping.store'), [
        'id_guru' => '',
        'id_mapel' => 999,
        'id_kelas' => 999,
    ])->assertSessionHasErrors(['id_guru', 'id_mapel', 'id_kelas']);

    $payload = [
        'id_guru' => $guru->id,
        'id_mapel' => $mapel->id,
        'id_kelas' => $kelas->id,
    ];

    $this->post(route('mapping.store'), $payload)->assertRedirect(route('mapping.index'));
    $this->from(route('mapping.create'))
        ->post(route('mapping.store'), $payload)
        ->assertRedirect(route('mapping.create'))
        ->assertSessionHasErrors('id_guru');
});

it('enforces the unique mapping combination in the database', function () {
    $guru = guruModel::create(['nama' => 'Guru Unique']);
    $mapel = mapelModel::create([
        'kode' => 'uni',
        'nama' => 'Unique Mapel',
        'jenis' => 'skk',
    ]);
    $jurusan = jurusanModel::create([
        'kode' => 'UNI',
        'nama' => 'Unique Jurusan',
    ]);
    $kelas = kelasModel::create([
        'nama' => 'Unique Kelas',
        'id_jurusan' => $jurusan->id,
    ]);

    guruMapelKelasModel::create([
        'id_guru' => $guru->id,
        'id_mapel' => $mapel->id,
        'id_kelas' => $kelas->id,
    ]);

    expect(fn () => guruMapelKelasModel::create([
        'id_guru' => $guru->id,
        'id_mapel' => $mapel->id,
        'id_kelas' => $kelas->id,
    ]))->toThrow(QueryException::class);
});

it('keeps mapping pagination compact when many pages are available', function () {
    $guru = guruModel::create(['nama' => 'Guru Pagination']);
    $mapel = mapelModel::create([
        'kode' => 'page',
        'nama' => 'Pagination',
        'jenis' => 'skk',
    ]);
    $jurusan = jurusanModel::create([
        'kode' => 'PAGE',
        'nama' => 'Jurusan Pagination',
    ]);
    $timestamp = now();

    kelasModel::insert(
        collect(range(1, 150))
            ->map(fn (int $number) => [
                'nama' => "Kelas {$number}",
                'id_jurusan' => $jurusan->id,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ])
            ->all()
    );

    $mappings = kelasModel::query()
        ->pluck('id')
        ->map(fn (int $kelasId) => [
            'id_guru' => $guru->id,
            'id_mapel' => $mapel->id,
            'id_kelas' => $kelasId,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ])
        ->all();

    guruMapelKelasModel::insert($mappings);

    $response = $this->get(route('mapping.index', ['page' => 5]))
        ->assertOk()
        ->assertSee('aria-label="Pagination"', false)
        ->assertSee('page=10')
        ->assertDontSee('page=2');

    expect(substr_count($response->getContent(), 'class="pager-btn'))->toBe(9);
});
