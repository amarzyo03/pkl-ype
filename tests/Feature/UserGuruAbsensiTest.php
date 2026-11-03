<?php

use App\Models\absensiModel;
use App\Models\dudiModel;
use App\Models\guruModel;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows attendance for the selected date and only the teachers approved dudi students', function () {
    $jurusan = jurusanModel::query()->create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);
    $kelas = kelasModel::query()->create([
        'nama' => 'XI RPL 1',
        'id_jurusan' => $jurusan->id,
    ]);
    $guru = guruModel::query()->create(['nama' => 'Guru Absensi']);
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
        'username' => 'guru-absensi-list',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);
    $siswa = siswaModel::query()->create([
        'nis' => '10001',
        'nisn' => '20001',
        'nama' => 'Siswa Guru',
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
    absensiModel::query()->create([
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-11-02',
        'status' => 'hadir',
        'foto' => 'siswa_20261102_photo.jpg',
        'keterangan' => 'Tepat waktu',
    ]);
    absensiModel::query()->create([
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-11-01',
        'status' => 'izin',
    ]);
    absensiModel::query()->create([
        'id_siswa' => $otherStudent->id,
        'tanggal' => '2026-11-02',
        'status' => 'hadir',
    ]);
    absensiModel::query()->create([
        'id_siswa' => $pendingStudent->id,
        'tanggal' => '2026-11-02',
        'status' => 'hadir',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->get(route('userGuru.absensi', ['tanggal' => '2026-11-02']))
        ->assertOk()
        ->assertViewIs('userGuru.absensi.index')
        ->assertSee('value="2026-11-02"', false)
        ->assertSee('Siswa Guru')
        ->assertSee('DUDI Bimbingan')
        ->assertSee('href="'.asset('assets/static/absensi/siswa_20261102_photo.jpg').'"', false)
        ->assertSee('Lihat foto')
        ->assertSee('XI RPL 1')
        ->assertSee('Hadir')
        ->assertDontSee('Siswa Guru Lain')
        ->assertDontSee('Siswa Pending');

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->get(route('userGuru.absensi'))
        ->assertOk()
        ->assertViewIs('userGuru.absensi.index')
        ->assertSee('value=""', false)
        ->assertSee('Siswa Guru')
        ->assertSee('01/11/2026')
        ->assertSee('02/11/2026')
        ->assertSee('Menampilkan 2 absensi')
        ->assertDontSee('Siswa Guru Lain')
        ->assertDontSee('Siswa Pending');
});

it('returns only selected-date attendance in an ajax response', function () {
    $jurusan = jurusanModel::query()->create([
        'kode' => 'TKJ',
        'nama' => 'Teknik Komputer dan Jaringan',
    ]);
    $kelas = kelasModel::query()->create([
        'nama' => 'XI TKJ 1',
        'id_jurusan' => $jurusan->id,
    ]);
    $guru = guruModel::query()->create(['nama' => 'Guru AJAX Absensi']);
    $dudi = dudiModel::query()->create([
        'nama' => 'DUDI AJAX',
        'alamat' => 'Jl. AJAX',
        'telp' => '021123457',
        'pic' => 'PIC',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $guru->id,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru-absensi-ajax',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);
    $siswa = siswaModel::query()->create([
        'nis' => '30001',
        'nisn' => '40001',
        'nama' => 'Siswa AJAX',
        'id_kelas' => $kelas->id,
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswa->id,
        'id_dudi' => (string) $dudi->id,
        'status' => 'disetujui',
    ]);
    absensiModel::query()->create([
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-11-02',
        'status' => 'sakit',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
        ->get(route('userGuru.absensi', ['tanggal' => '2026-11-02']))
        ->assertOk()
        ->assertViewIs('userGuru.absensi._results')
        ->assertSee('Siswa AJAX')
        ->assertSee('Sakit');
});

it('rejects invalid attendance dates', function () {
    $guru = guruModel::query()->create(['nama' => 'Guru Tanggal']);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru-absensi-invalid',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);

    $this->from(route('userGuru.absensi'))
        ->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->get(route('userGuru.absensi', ['tanggal' => 'kemarin']))
        ->assertRedirect(route('userGuru.absensi'))
        ->assertSessionHasErrors('tanggal');
});
