<?php

use App\Models\absensiModel;
use App\Models\dudiModel;
use App\Models\guruModel;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\tugasModel;
use App\Models\tugasStatusModel;
use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows summaries and menu links for the signed-in teacher', function () {
    $jurusan = jurusanModel::query()->create(['kode' => 'GURU-DASH', 'nama' => 'Jurusan Guru']);
    $kelas = kelasModel::query()->create(['nama' => 'XI Guru', 'id_jurusan' => $jurusan->id]);
    $guru = guruModel::query()->create(['nama' => 'Guru Dashboard']);
    $otherGuru = guruModel::query()->create(['nama' => 'Guru Lain']);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru-dashboard',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);
    $dudi = dudiModel::query()->create([
        'nama' => 'DUDI Bimbingan',
        'alamat' => 'Jl. Guru',
        'telp' => '08123456789',
        'pic' => 'PIC Guru',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $guru->id,
    ]);
    $otherDudi = dudiModel::query()->create([
        'nama' => 'DUDI Guru Lain',
        'alamat' => 'Jl. Lain',
        'telp' => '08123456780',
        'pic' => 'PIC Lain',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $otherGuru->id,
    ]);
    $siswa = siswaModel::query()->create([
        'nis' => 'GURU-DASH-1',
        'nisn' => 'GURU-DASH-1',
        'nama' => 'Siswa Bimbingan',
        'id_kelas' => $kelas->id,
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswa->id,
        'id_dudi' => (string) $dudi->id,
        'status' => 'disetujui',
    ]);
    $otherSiswa = siswaModel::query()->create([
        'nis' => 'GURU-DASH-2',
        'nisn' => 'GURU-DASH-2',
        'nama' => 'Siswa Guru Lain',
        'id_kelas' => $kelas->id,
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $otherSiswa->id,
        'id_dudi' => (string) $otherDudi->id,
        'status' => 'disetujui',
    ]);

    absensiModel::query()->create([
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-10-22',
        'status' => 'hadir',
    ]);
    absensiModel::query()->create([
        'id_siswa' => $otherSiswa->id,
        'tanggal' => '2026-10-23',
        'status' => 'izin',
    ]);
    $tugas = tugasModel::query()->create([
        'id_guru' => $guru->id,
        'tanggal' => '2026-10-22',
        'judul' => 'Tugas Guru Dashboard',
        'deskripsi' => 'Deskripsi tugas.',
    ]);
    tugasModel::query()->create([
        'id_guru' => $otherGuru->id,
        'tanggal' => '2026-10-23',
        'judul' => 'Tugas Guru Lain',
        'deskripsi' => 'Tidak boleh dihitung.',
    ]);
    tugasStatusModel::query()->create([
        'id_siswa' => $siswa->id,
        'id_tugas' => $tugas->id,
        'tanggal' => '2026-10-23',
        'status' => 'dikerjakan',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->get(route('userGuru.dashboard'))
        ->assertOk()
        ->assertViewIs('userGuru.dashboard')
        ->assertSee('Guru Dashboard')
        ->assertSee('Siswa Bimbingan')
        ->assertSee('DUDI Bimbingan')
        ->assertSee('Tugas Guru Dashboard')
        ->assertDontSee('Tugas Guru Lain')
        ->assertSee(route('userGuru.daftarDudi'), false)
        ->assertSee(route('userGuru.daftarSiswa'), false)
        ->assertSee(route('userGuru.absensi'), false)
        ->assertSee(route('tugas'), false)
        ->assertViewHas('totalDudi', 1)
        ->assertViewHas('totalSiswa', 1)
        ->assertViewHas('totalAbsensi', 1)
        ->assertViewHas('totalTugas', 1)
        ->assertViewHas('totalPengumpulan', 1);
});
