<?php

use App\Models\dudiModel;
use App\Models\guruModel;
use App\Models\jurnalModel;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a teacher to monitor journals of approved students from their own dudi', function () {
    $jurusan = jurusanModel::query()->create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);
    $kelas = kelasModel::query()->create([
        'nama' => 'XI RPL 1',
        'id_jurusan' => $jurusan->id,
    ]);
    $guru = guruModel::query()->create(['nama' => 'Guru Jurnal']);
    $otherGuru = guruModel::query()->create(['nama' => 'Guru Lain']);
    $dudi = dudiModel::query()->create([
        'nama' => 'DUDI Bimbingan',
        'alamat' => 'Jl. Industri',
        'telp' => '021123456',
        'pic' => 'PIC',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $guru->id,
    ]);
    $otherDudi = dudiModel::query()->create([
        'nama' => 'DUDI Guru Lain',
        'alamat' => 'Jl. Lain',
        'telp' => '021654321',
        'pic' => 'PIC Lain',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $otherGuru->id,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru-jurnal-monitoring',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);
    $siswa = siswaModel::query()->create([
        'nis' => '10001',
        'nisn' => '20001',
        'nama' => 'Siswa Bimbingan',
        'id_kelas' => $kelas->id,
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswa->id,
        'id_dudi' => (string) $dudi->id,
        'status' => 'disetujui',
    ]);
    $otherStudent = siswaModel::query()->create([
        'nis' => '10002',
        'nisn' => '20002',
        'nama' => 'Siswa Guru Lain',
        'id_kelas' => $kelas->id,
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $otherStudent->id,
        'id_dudi' => (string) $otherDudi->id,
        'status' => 'disetujui',
    ]);
    $pendingStudent = siswaModel::query()->create([
        'nis' => '10003',
        'nisn' => '20003',
        'nama' => 'Siswa Pending',
        'id_kelas' => $kelas->id,
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $pendingStudent->id,
        'id_dudi' => (string) $dudi->id,
        'status' => 'pending',
    ]);

    jurnalModel::query()->create([
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-11-02',
        'kegiatan' => 'Mengerjakan fitur laporan',
    ]);
    jurnalModel::query()->create([
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-11-03',
        'kegiatan' => 'Menguji aplikasi',
    ]);
    jurnalModel::query()->create([
        'id_siswa' => $otherStudent->id,
        'tanggal' => '2026-11-03',
        'kegiatan' => 'Kegiatan di luar bimbingan',
    ]);
    jurnalModel::query()->create([
        'id_siswa' => $pendingStudent->id,
        'tanggal' => '2026-11-03',
        'kegiatan' => 'Kegiatan siswa pending',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->get(route('userGuru.jurnal'))
        ->assertOk()
        ->assertViewIs('userGuru.jurnal.index')
        ->assertSee('Monitoring')
        ->assertSee('Siswa Bimbingan')
        ->assertSee('XI RPL 1')
        ->assertSee('DUDI Bimbingan')
        ->assertSee('Menampilkan 2 jurnal siswa bimbingan')
        ->assertSeeInOrder([
            '03/11/2026',
            'Menguji aplikasi',
            '02/11/2026',
            'Mengerjakan fitur laporan',
        ])
        ->assertDontSee('Siswa Guru Lain')
        ->assertDontSee('Siswa Pending')
        ->assertDontSee('Kegiatan di luar bimbingan')
        ->assertDontSee('Kegiatan siswa pending');
});
