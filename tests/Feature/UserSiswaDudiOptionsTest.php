<?php

use App\Models\dudiModel;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use App\Models\siswaModel;
use App\Models\userModel;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

test('groups DUDI options by jurusan on the registration form', function () {
    $dudi = collect([
        (object) [
            'id' => 1,
            'nama' => 'PT Contoh',
            'id_jurusan' => 10,
            'jurusan' => (object) ['nama' => 'RPL'],
        ],
        (object) [
            'id' => 2,
            'nama' => 'CV Contoh',
            'id_jurusan' => 20,
            'jurusan' => (object) ['nama' => 'TKJ'],
        ],
    ]);
    $siswa = (object) ['id' => 1, 'nama' => 'Siswa Contoh'];

    $this->withViewErrors([])->view('userSiswa.pendaftaran.pendaftaran', compact('dudi', 'siswa'))
        ->assertSee('<optgroup label="RPL">', false)
        ->assertSee('<optgroup label="TKJ">', false)
        ->assertSee('value="1"', false)
        ->assertSee('value="2"', false);
});

test('groups DUDI options by jurusan on the edit form and preserves the current choice', function () {
    $dudi = collect([
        (object) [
            'id' => 1,
            'nama' => 'PT Contoh',
            'id_jurusan' => 10,
            'jurusan' => (object) ['nama' => 'RPL'],
        ],
        (object) [
            'id' => 2,
            'nama' => 'CV Contoh',
            'id_jurusan' => 20,
            'jurusan' => (object) ['nama' => 'TKJ'],
        ],
    ]);
    $siswa = (object) ['id' => 1, 'nama' => 'Siswa Contoh'];
    $pendaftaran = (object) [
        'id' => 1,
        'dudi' => (object) ['id' => 2],
    ];

    $this->withViewErrors([])->view('userSiswa.pendaftaran.edit', compact('dudi', 'pendaftaran', 'siswa'))
        ->assertSee('<optgroup label="RPL">', false)
        ->assertSee('<optgroup label="TKJ">', false)
        ->assertSee('value="2" selected', false);
});

it('loads jurusan for DUDI options in one query regardless of the number of jurusan', function () {
    $jurusanPertama = jurusanModel::query()->create(['kode' => 'RPL', 'nama' => 'RPL']);
    $jurusanKedua = jurusanModel::query()->create(['kode' => 'TKJ', 'nama' => 'TKJ']);
    $kelas = kelasModel::query()->create(['nama' => 'XI RPL', 'id_jurusan' => $jurusanPertama->id]);
    $siswa = siswaModel::query()->create([
        'nis' => 'DUDI-QUERY-1',
        'nisn' => 'DUDI-QUERY-1',
        'nama' => 'Siswa Query',
        'id_kelas' => $kelas->id,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $siswa->id,
        'username' => 'siswa-dudi-query',
        'password' => 'password',
        'role' => 'siswa',
        'status' => 'active',
    ]);

    foreach ([$jurusanPertama, $jurusanKedua] as $index => $jurusan) {
        dudiModel::query()->create([
            'nama' => 'DUDI '.$index,
            'alamat' => 'Alamat DUDI',
            'telp' => '08123456789',
            'pic' => 'PIC DUDI',
            'id_jurusan' => $jurusan->id,
            'id_guru' => 1,
        ]);
    }

    $jurusanQueries = 0;
    DB::listen(function (QueryExecuted $query) use (&$jurusanQueries): void {
        if (str_contains(strtolower($query->sql), 'tb_jurusan')) {
            $jurusanQueries++;
        }
    });

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'siswa'])
        ->get(route('userSiswa.pendaftaran'))
        ->assertOk()
        ->assertSee('<optgroup label="RPL">', false)
        ->assertSee('<optgroup label="TKJ">', false);

    expect($jurusanQueries)->toBe(1);
});
