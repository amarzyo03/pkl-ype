<?php

use App\Models\jurusanModel;
use App\Models\kelasModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create, update, and delete a kelas', function () {
    $jurusan = jurusanModel::create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);

    $response = $this->post(route('kelas.save'), [
        'tingkat' => 'XI',
        'id_jurusan' => $jurusan->id,
        'nomor' => 1,
    ]);

    $response->assertRedirect(route('kelas'));

    $this->assertDatabaseHas('tb_kelas', [
        'id_jurusan' => $jurusan->id,
        'nama' => 'XI RPL 1',
    ]);

    $kelas = kelasModel::where('nama', 'XI RPL 1')->firstOrFail();

    $this->put(route('kelas.update', $kelas->id), [
        'tingkat' => 'XII',
        'id_jurusan' => $jurusan->id,
        'nomor' => 2,
    ])->assertRedirect(route('kelas'));

    $this->assertDatabaseHas('tb_kelas', [
        'id' => $kelas->id,
        'id_jurusan' => $jurusan->id,
        'nama' => 'XII RPL 2',
    ]);

    $this->delete(route('kelas.delete', $kelas->id))->assertRedirect(route('kelas'));

    $this->assertSoftDeleted('tb_kelas', [
        'id' => $kelas->id,
    ]);
});
