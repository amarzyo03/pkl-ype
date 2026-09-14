<?php

use App\Models\siswaModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create, update, and delete a siswa', function () {
    $response = $this->post(route('siswa.save'), [
        'nis' => 'NIS-001',
        'nisn' => 'NISN-001',
        'nama' => 'Budi Santoso',
        'kelas' => 'XII IPA 1',
        'username' => 'budisantoso',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
        'status' => 'active',
    ]);

    $response->assertRedirect(route('siswa'));

    $this->assertDatabaseHas('tb_siswa', [
        'nis' => 'NIS-001',
        'nisn' => 'NISN-001',
        'username' => 'budisantoso',
        'status' => 'active',
    ]);

    $siswa = siswaModel::where('username', 'budisantoso')->firstOrFail();

    $this->put(route('siswa.update', $siswa->id), [
        'nis' => 'NIS-002',
        'nisn' => 'NISN-002',
        'nama' => 'Budi Santoso Updated',
        'kelas' => 'XII IPA 2',
        'username' => 'budisantoso.updated',
        'status' => 'inactive',
    ])->assertRedirect(route('siswa'));

    $this->assertDatabaseHas('tb_siswa', [
        'id' => $siswa->id,
        'nis' => 'NIS-002',
        'nisn' => 'NISN-002',
        'nama' => 'Budi Santoso Updated',
        'kelas' => 'XII IPA 2',
        'username' => 'budisantoso.updated',
        'status' => 'inactive',
    ]);

    $this->delete(route('siswa.delete', $siswa->id))->assertRedirect(route('siswa'));

    $this->assertSoftDeleted('tb_siswa', [
        'id' => $siswa->id,
    ]);
});
