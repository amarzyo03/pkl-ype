<?php

use App\Models\absensiModel;
use App\Models\dudiModel;
use App\Models\guruModel;
use App\Models\jurnalModel;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\tugasModel;
use App\Models\tugasStatusModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withSession([
        'auth_id' => 1,
        'auth_role' => 'admin',
    ]);
});

test('admin dashboard shows school and registration totals', function () {
    $jurusan = jurusanModel::query()->create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);
    $kelas = kelasModel::query()->create([
        'nama' => 'XII RPL 1',
        'id_jurusan' => $jurusan->id,
    ]);
    $guru = guruModel::query()->create([
        'nama' => 'Ibu Guru',
        'id_jurusan' => $jurusan->id,
    ]);
    $dudi = dudiModel::query()->create([
        'nama' => 'PT Contoh',
        'alamat' => 'Jl. Industri',
        'telp' => '0282123456',
        'pic' => 'Bapak Mitra',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $guru->id,
    ]);

    $siswas = collect(range(1, 4))->map(fn (int $number): siswaModel => siswaModel::query()->create([
        'nis' => "NIS-{$number}",
        'nisn' => "NISN-{$number}",
        'nama' => "Siswa {$number}",
        'id_kelas' => $kelas->id,
        'status' => $number === 4 ? 'inactive' : 'active',
    ]));

    foreach (['pending', 'disetujui', 'ditolak', 'pending'] as $index => $status) {
        $pendaftaran = pendaftaranModel::query()->create([
            'id_siswa' => $siswas[$index]->id,
            'id_dudi' => $dudi->id,
            'status' => $status,
        ]);

        if ($index === 3) {
            $pendaftaran->delete();
        }
    }

    jurnalModel::query()->create([
        'id_siswa' => $siswas[0]->id,
        'tanggal' => today()->toDateString(),
        'kegiatan' => 'Membuat laporan praktik',
    ]);
    jurnalModel::query()->create([
        'id_siswa' => $siswas[0]->id,
        'tanggal' => today()->toDateString(),
        'kegiatan' => 'Melanjutkan laporan praktik',
    ]);
    jurnalModel::query()->create([
        'id_siswa' => $siswas[1]->id,
        'tanggal' => today()->subMonth()->toDateString(),
        'kegiatan' => 'Jurnal bulan lalu',
    ]);
    jurnalModel::query()->create([
        'id_siswa' => $siswas[3]->id,
        'tanggal' => today()->toDateString(),
        'kegiatan' => 'Jurnal siswa nonaktif',
    ]);

    $tugasPertama = tugasModel::query()->create([
        'id_guru' => $guru->id,
        'tanggal' => today()->toDateString(),
        'judul' => 'Tugas pertama',
        'deskripsi' => 'Deskripsi tugas pertama.',
    ]);
    $tugasKedua = tugasModel::query()->create([
        'id_guru' => $guru->id,
        'tanggal' => today()->toDateString(),
        'judul' => 'Tugas kedua',
        'deskripsi' => 'Deskripsi tugas kedua.',
    ]);
    foreach ([$siswas[0], $siswas[0], $siswas[1], $siswas[3]] as $siswa) {
        tugasStatusModel::query()->create([
            'id_siswa' => $siswa->id,
            'id_tugas' => $siswa->id === $siswas[1]->id ? $tugasKedua->id : $tugasPertama->id,
            'tanggal' => today()->toDateString(),
            'status' => 'dikerjakan',
        ]);
    }

    absensiModel::query()->create([
        'id_siswa' => $siswas[0]->id,
        'tanggal' => today()->toDateString(),
        'status' => 'hadir',
    ]);
    absensiModel::query()->create([
        'id_siswa' => $siswas[1]->id,
        'tanggal' => today()->toDateString(),
        'status' => 'izin',
    ]);
    absensiModel::query()->create([
        'id_siswa' => $siswas[2]->id,
        'tanggal' => today()->subMonth()->toDateString(),
        'status' => 'hadir',
    ]);

    $this->get(route('dashboard'))
        ->assertOk()
        ->assertViewHas('totalSiswa', 4)
        ->assertViewHas('siswaAktif', 3)
        ->assertViewHas('jumlahGuru', 1)
        ->assertViewHas('jumlahDudi', 1)
        ->assertViewHas('jumlahKelas', 1)
        ->assertViewHas('jumlahJurusan', 1)
        ->assertViewHas('totalPendaftaran', 3)
        ->assertViewHas('pendaftaranPending', 1)
        ->assertViewHas('pendaftaranDisetujui', 1)
        ->assertViewHas('pendaftaranDitolak', 1)
        ->assertViewHas('jumlahTugas', 2)
        ->assertViewHas('jumlahTugasDikerjakan', 2)
        ->assertViewHas('jumlahTugasBelumDikerjakan', 4)
        ->assertViewHas('jumlahJurnalBulanIni', 2)
        ->assertViewHas('jumlahSiswaBelumMengumpulkanJurnal', 2)
        ->assertViewHas('jumlahAbsensi', 3)
        ->assertViewHas('jumlahAbsensiHariIni', 2)
        ->assertViewHas('jumlahHadirHariIni', 1)
        ->assertSee('Siswa 1')
        ->assertSee('PT Contoh');
});

test('admin dashboard handles an empty registration status safely', function () {
    $this->get(route('dashboard'))
        ->assertOk()
        ->assertViewHas('jumlahTugasDikerjakan', 0)
        ->assertViewHas('jumlahTugasBelumDikerjakan', 0)
        ->assertViewHas('jumlahJurnalBulanIni', 0)
        ->assertViewHas('jumlahSiswaBelumMengumpulkanJurnal', 0)
        ->assertViewHas('jumlahAbsensi', 0)
        ->assertViewHas('totalPendaftaran', 0)
        ->assertViewHas('persentasePending', 0)
        ->assertViewHas('persentaseDisetujui', 0)
        ->assertViewHas('persentaseDitolak', 0)
        ->assertSee('Belum ada data pendaftaran.');
});
