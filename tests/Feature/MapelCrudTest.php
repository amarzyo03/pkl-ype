<?php

use App\Models\mapelModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin']);
});

it('can create, update, list, and delete mapel data', function () {
    $this->get(route('mapel.add'))
        ->assertOk()
        ->assertSee('name="jenis"', false);

    $this->post(route('mapel.save'), [
        'kode' => 'mtk',
        'nama' => 'Matematika',
        'jenis' => 'skk',
    ])->assertRedirect(route('mapel'));

    $mapel = mapelModel::query()->where('kode', 'mtk')->firstOrFail();

    $this->get(route('mapel'))
        ->assertOk()
        ->assertSee('Matematika');
    $this->get(route('mapel', ['search' => 'mtk']))
        ->assertOk()
        ->assertSee('Matematika');

    $this->put(route('mapel.update', $mapel->id), [
        'kode' => 'mtk',
        'nama' => 'Matematika Terapan',
        'jenis' => 'produktif',
    ])->assertRedirect(route('mapel'));

    $this->get(route('mapel.edit', $mapel->id))
        ->assertOk()
        ->assertSee('Matematika Terapan');

    $this->assertDatabaseHas('tb_mapel', [
        'id' => $mapel->id,
        'nama' => 'Matematika Terapan',
        'jenis' => 'produktif',
    ]);

    $this->delete(route('mapel.delete', $mapel->id))->assertRedirect(route('mapel'));
    $this->assertSoftDeleted('tb_mapel', ['id' => $mapel->id]);
});

it('validates mapel codes and types', function () {
    mapelModel::create([
        'kode' => 'mtk',
        'nama' => 'Matematika',
        'jenis' => 'skk',
    ]);

    $this->post(route('mapel.save'), [
        'kode' => 'mtk',
        'nama' => 'Matematika lain',
        'jenis' => 'produktif',
    ])->assertSessionHasErrors('kode');

    $this->post(route('mapel.save'), [
        'kode' => 'fis',
        'nama' => 'Fisika',
        'jenis' => 'pilihan',
    ])->assertSessionHasErrors('jenis');
});

it('keeps pagination compact when there are many mapel pages', function () {
    $timestamp = now();
    $mapels = collect(range(1, 150))
        ->map(fn (int $number) => [
            'kode' => "mapel-{$number}",
            'nama' => "Mata Pelajaran {$number}",
            'jenis' => 'skk',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ])
        ->all();

    mapelModel::insert($mapels);

    $response = $this->get(route('mapel', ['page' => 5]))
        ->assertOk()
        ->assertSee('page=10')
        ->assertDontSee('page=2');

    expect(substr_count($response->getContent(), 'class="pager-btn'))->toBe(9);
});
