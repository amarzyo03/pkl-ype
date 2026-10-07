<?php

use App\Models\kelasModel;
use App\Models\siswaModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create, update, and delete a siswa', function () {
    kelasModel::create([
        'nama' => 'XII IPA 1',
        'id_jurusan' => 1,
    ]);
    kelasModel::create([
        'nama' => 'XII IPA 2',
        'id_jurusan' => 1,
    ]);

    $this->get(route('siswa.add'))
        ->assertOk()
        ->assertSee('XII IPA 1')
        ->assertSee('XII IPA 2');

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

    $this->get(route('siswa.edit', $siswa->id))
        ->assertOk()
        ->assertSee('XII IPA 1')
        ->assertSee('XII IPA 2');

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

it('only accepts a class that exists in tb_kelas', function () {
    $deletedKelas = kelasModel::create([
        'nama' => 'Kelas Terhapus',
        'id_jurusan' => 1,
    ]);
    $deletedKelas->delete();

    $this->from(route('siswa.add'))
        ->post(route('siswa.save'), [
            'nis' => 'NIS-003',
            'nisn' => 'NISN-003',
            'nama' => 'Guru Kelas Tidak Ada',
            'kelas' => 'Kelas Tidak Terdaftar',
            'username' => 'siswa.invalid.kelas',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'status' => 'active',
        ])
        ->assertRedirect(route('siswa.add'))
        ->assertSessionHasErrors('kelas');

    $this->from(route('siswa.add'))
        ->post(route('siswa.save'), [
            'nis' => 'NIS-004',
            'nisn' => 'NISN-004',
            'nama' => 'Siswa Kelas Terhapus',
            'kelas' => 'Kelas Terhapus',
            'username' => 'siswa.deleted.kelas',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'status' => 'active',
        ])
        ->assertRedirect(route('siswa.add'))
        ->assertSessionHasErrors('kelas');

    $this->assertDatabaseCount('tb_siswa', 0);
});
