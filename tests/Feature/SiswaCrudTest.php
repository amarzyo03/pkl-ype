<?php

use App\Imports\SiswaImport;
use App\Models\kelasModel;
use App\Models\siswaModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

it('can create, update, and delete a siswa', function () {
    $kelasPertama = kelasModel::create([
        'nama' => 'XII IPA 1',
        'id_jurusan' => 1,
    ]);
    $kelasKedua = kelasModel::create([
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
        'id_kelas' => $kelasPertama->id,
        'username' => 'budisantoso',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
        'status' => 'active',
    ]);

    $response->assertRedirect(route('siswa'));

    $this->assertDatabaseHas('tb_siswa', [
        'nis' => 'NIS-001',
        'nisn' => 'NISN-001',
        'id_kelas' => $kelasPertama->id,
        'username' => 'budisantoso',
        'status' => 'active',
    ]);

    $siswa = siswaModel::where('username', 'budisantoso')->firstOrFail();

    $editResponse = $this->get(route('siswa.edit', $siswa->id))
        ->assertOk()
        ->assertSee('XII IPA 1')
        ->assertSee('XII IPA 2');

    $this->assertMatchesRegularExpression(
        '/<option value="'.$kelasPertama->id.'"\s+selected>/',
        $editResponse->getContent()
    );

    $this->get(route('siswa'))
        ->assertOk()
        ->assertSee('XII IPA 1');

    $this->put(route('siswa.update', $siswa->id), [
        'nis' => 'NIS-002',
        'nisn' => 'NISN-002',
        'nama' => 'Budi Santoso Updated',
        'id_kelas' => $kelasKedua->id,
        'username' => 'budisantoso.updated',
        'status' => 'inactive',
    ])->assertRedirect(route('siswa'));

    $this->assertDatabaseHas('tb_siswa', [
        'id' => $siswa->id,
        'nis' => 'NIS-002',
        'nisn' => 'NISN-002',
        'nama' => 'Budi Santoso Updated',
        'id_kelas' => $kelasKedua->id,
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
            'id_kelas' => '9999',
            'username' => 'siswa.invalid.kelas',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
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
            'username' => 'siswa.deleted.kelas',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
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
            'username' => 'siswa.import',
            'password' => 'secret123',
            'status' => 'active',
        ],
    ]));

    $this->assertDatabaseHas('tb_siswa', [
        'nis' => 'NIS-005',
        'id_kelas' => $kelas->id,
    ]);
});

it('converts existing student class names to class IDs', function () {
    $kelas = kelasModel::create([
        'nama' => 'XII IPA 4',
        'id_jurusan' => 1,
    ]);

    Schema::table('tb_siswa', function (Blueprint $table): void {
        $table->dropColumn('id_kelas');
    });
    Schema::table('tb_siswa', function (Blueprint $table): void {
        $table->string('kelas');
    });

    DB::table('tb_siswa')->insert([
        'nis' => 'NIS-006',
        'nisn' => 'NISN-006',
        'nama' => 'Siswa Lama',
        'kelas' => 'xii ipa 4',
        'username' => 'siswa.lama',
        'password' => 'hashed-password',
        'status' => 'active',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $migration = require database_path('migrations/2026_10_14_082139_convert_siswa_kelas_to_id_kelas.php');
    $migration->up();

    $this->assertDatabaseHas('tb_siswa', [
        'nis' => 'NIS-006',
        'id_kelas' => $kelas->id,
    ]);
    expect(Schema::hasColumn('tb_siswa', 'kelas'))->toBeFalse();
});
