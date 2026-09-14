<?php

use App\Models\jurusanModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create, update, and delete a jurusan', function () {
    $response = $this->post(route('jurusan.save'), [
        'kode' => 'JRS-001',
        'nama' => 'Teknik Informatika',
    ]);

    $response->assertRedirect(route('jurusan'));

    $this->assertDatabaseHas('tb_jurusan', [
        'kode' => 'JRS-001',
        'nama' => 'Teknik Informatika',
    ]);

    $jurusan = jurusanModel::where('kode', 'JRS-001')->firstOrFail();

    $this->put(route('jurusan.update', $jurusan->id), [
        'kode' => 'JRS-002',
        'nama' => 'Teknik Komputer Jaringan',
    ])->assertRedirect(route('jurusan'));

    $this->assertDatabaseHas('tb_jurusan', [
        'id' => $jurusan->id,
        'kode' => 'JRS-002',
        'nama' => 'Teknik Komputer Jaringan',
    ]);

    $this->delete(route('jurusan.delete', $jurusan->id))->assertRedirect(route('jurusan'));

    $this->assertSoftDeleted('tb_jurusan', [
        'id' => $jurusan->id,
    ]);
});
