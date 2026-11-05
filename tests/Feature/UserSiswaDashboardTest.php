<?php

use App\Models\absensiModel;
use App\Models\dudiModel;
use App\Models\jurnalModel;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\tugasModel;
use App\Models\tugasStatusModel;
use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows student information and activity summaries on the dashboard', function () {
    $jurusan = jurusanModel::query()->create(['kode' => 'DASH', 'nama' => 'Jurusan Dashboard']);
    $kelas = kelasModel::query()->create(['nama' => 'XI Dashboard', 'id_jurusan' => $jurusan->id]);
    $siswa = siswaModel::query()->create([
        'nis' => 'DASH-1',
        'nisn' => 'DASH-1',
        'nama' => 'Siswa Dashboard',
        'id_kelas' => $kelas->id,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $siswa->id,
        'username' => 'dashboard-siswa',
        'password' => 'password',
        'role' => 'siswa',
        'status' => 'active',
    ]);
    $guru = createGuruForTest(['nama' => 'Guru Dashboard']);
    $dudi = dudiModel::query()->create([
        'nama' => 'DUDI Dashboard',
        'alamat' => 'Jl. Dashboard',
        'telp' => '08123456789',
        'pic' => 'Kontak',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $guru->id,
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswa->id,
        'id_dudi' => (string) $dudi->id,
        'status' => 'disetujui',
    ]);

    absensiModel::query()->create([
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-10-20',
        'status' => 'hadir',
    ]);
    absensiModel::query()->create([
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-10-22',
        'status' => 'izin',
    ]);
    jurnalModel::query()->create([
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-10-20',
        'kegiatan' => 'Jurnal lama dashboard.',
    ]);
    jurnalModel::query()->create([
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-10-22',
        'kegiatan' => 'Jurnal terbaru dashboard.',
    ]);
    $tugasLama = tugasModel::query()->create([
        'id_guru' => $guru->id,
        'tanggal' => '2026-10-20',
        'judul' => 'Tugas Lama',
        'deskripsi' => 'Deskripsi tugas.',
    ]);
    tugasModel::query()->create([
        'id_guru' => $guru->id,
        'tanggal' => '2026-10-22',
        'judul' => 'Tugas Baru',
        'deskripsi' => 'Deskripsi tugas.',
    ]);
    tugasStatusModel::query()->create([
        'id_siswa' => $siswa->id,
        'id_tugas' => $tugasLama->id,
        'tanggal' => '2026-10-22',
        'status' => 'dikerjakan',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'siswa'])
        ->get(route('userSiswa.dashboard'))
        ->assertOk()
        ->assertSee('Siswa Dashboard')
        ->assertSee('XI Dashboard')
        ->assertSee('DUDI Dashboard')
        ->assertSee('Jurnal terbaru dashboard.')
        ->assertSee('22/10/2026')
        ->assertSee(route('userSiswa.pendaftaran.status'), false)
        ->assertSee(route('userSiswa.daftarSiswa'), false)
        ->assertSee(route('userSiswa.absensi'), false)
        ->assertSee(route('userSiswa.jurnal'), false)
        ->assertSee(route('userSiswa.tugas'), false)
        ->assertViewHas('totalAbsensi', 2)
        ->assertViewHas('totalJurnal', 2)
        ->assertViewHas('totalTugas', 2)
        ->assertViewHas('tugasSelesai', 1);
});
