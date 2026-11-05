<?php

use App\Imports\SiswaImport;
use App\Models\kelasModel;
use App\Models\siswaModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin']);
});

it('can create, update, and delete a siswa', function () {
    $kelasPertama = kelasModel::create([
        'nama' => 'XII IPA 1',
        'id_jurusan' => 1,
    ]);
    $kelasKedua = kelasModel::create([
        'nama' => 'XII IPA 2',
        'id_jurusan' => 1,
    ]);

    $addResponse = $this->get(route('siswa.add'))
        ->assertOk()
        ->assertSee('XII IPA 1')
        ->assertSee('XII IPA 2');
    $addResponse->assertDontSee('name="username"', false)
        ->assertDontSee('name="password"', false);

    $response = $this->post(route('siswa.save'), [
        'nis' => 'NIS-001',
        'nisn' => 'NISN-001',
        'nama' => 'Budi Santoso',
        'id_kelas' => $kelasPertama->id,
        'status' => 'active',
        'username' => 'field-that-is-not-managed',
        'password' => 'field-that-is-not-managed',
    ]);

    $response->assertRedirect(route('siswa'));

    $this->assertDatabaseHas('tb_siswa', [
        'nis' => 'NIS-001',
        'nisn' => 'NISN-001',
        'nama' => 'Budi Santoso',
        'id_kelas' => $kelasPertama->id,
        'status' => 'active',
    ]);

    $siswa = siswaModel::where('nis', 'NIS-001')->firstOrFail();

    $editResponse = $this->get(route('siswa.edit', $siswa->id))
        ->assertOk()
        ->assertSee('XII IPA 1')
        ->assertSee('XII IPA 2');
    $editResponse->assertDontSee('name="username"', false)
        ->assertDontSee('name="password"', false);

    $this->assertMatchesRegularExpression(
        '/<option value="'.$kelasPertama->id.'"\s+selected>/',
        $editResponse->getContent()
    );

    $this->get(route('siswa'))
        ->assertOk()
        ->assertSee('XII IPA 1')
        ->assertDontSee('<th>Username</th>', false);

    $this->put(route('siswa.update', $siswa->id), [
        'nis' => 'NIS-002',
        'nisn' => 'NISN-002',
        'nama' => 'Budi Santoso Updated',
        'id_kelas' => $kelasKedua->id,
        'status' => 'inactive',
    ])->assertRedirect(route('siswa'));

    $this->assertDatabaseHas('tb_siswa', [
        'id' => $siswa->id,
        'nis' => 'NIS-002',
        'nisn' => 'NISN-002',
        'nama' => 'Budi Santoso Updated',
        'id_kelas' => $kelasKedua->id,
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
            'id_kelas' => '9999',
            'status' => 'active',
        ])
        ->assertRedirect(route('siswa.add'))
        ->assertSessionHasErrors('id_kelas');

    $this->from(route('siswa.add'))
        ->post(route('siswa.save'), [
            'nis' => 'NIS-004',
            'nisn' => 'NISN-004',
            'nama' => 'Siswa Kelas Terhapus',
            'id_kelas' => $deletedKelas->id,
            'status' => 'active',
        ])
        ->assertRedirect(route('siswa.add'))
        ->assertSessionHasErrors('id_kelas');

    $this->assertDatabaseCount('tb_siswa', 0);
});

it('imports a student using the class name and stores the class ID', function () {
    $kelas = kelasModel::create([
        'nama' => 'XII IPA 3',
        'id_jurusan' => 1,
    ]);

    (new SiswaImport)->collection(collect([
        [
            'nis' => 'NIS-005',
            'nisn' => 'NISN-005',
            'nama' => 'Siswa Import',
            'kelas' => 'XII IPA 3',
            'status' => 'active',
        ],
    ]));

    $this->assertDatabaseHas('tb_siswa', [
        'nis' => 'NIS-005',
        'nisn' => 'NISN-005',
        'nama' => 'Siswa Import',
        'id_kelas' => $kelas->id,
        'status' => 'active',
    ]);
});

it('stores student login credentials separately from the student record', function () {
    expect(Schema::hasColumn('tb_siswa', 'username'))->toBeFalse()
        ->and(Schema::hasColumn('tb_siswa', 'password'))->toBeFalse();
});
