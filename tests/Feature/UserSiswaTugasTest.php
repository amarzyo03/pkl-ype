<?php

use App\Models\guruMapelKelasModel;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use App\Models\mapelModel;
use App\Models\siswaModel;
use App\Models\tugasModel;
use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('shows active tasks with a kerjakan link for each task', function () {
    $guru = createGuruForTest([
        'nama' => 'Guru Tugas',
        'username' => 'guru-tugas',
        'password' => bcrypt('password'),
    ]);
    $jurusan = jurusanModel::query()->create(['kode' => 'TUGAS', 'nama' => 'Jurusan Tugas']);
    $kelas = kelasModel::query()->create(['nama' => 'Kelas Tugas', 'id_jurusan' => $jurusan->id]);
    $mapel = mapelModel::query()->create([
        'kode' => 'tugas',
        'nama' => 'Mapel Tugas',
        'jenis' => 'produktif',
    ]);
    guruMapelKelasModel::query()->create([
        'id_guru' => $guru->id,
        'id_mapel' => $mapel->id,
        'id_kelas' => $kelas->id,
    ]);
    $siswa = siswaModel::query()->create([
        'nis' => 'TUGAS-AKTIF-1',
        'nisn' => 'TUGAS-AKTIF-1',
        'nama' => 'Siswa Tugas',
        'id_kelas' => $kelas->id,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $siswa->id,
        'username' => 'user-tugas',
        'password' => 'password',
        'role' => 'siswa',
        'status' => 'active',
    ]);

    $tugas = tugasModel::query()->create([
        'id_guru' => $guru->id,
        'tanggal' => '2026-10-20',
        'judul' => 'Tugas Aktif',
        'deskripsi' => 'Deskripsi tugas.',
    ]);

    $tugasTerhapus = tugasModel::query()->create([
        'id_guru' => $guru->id,
        'tanggal' => '2026-10-19',
        'judul' => 'Tugas Terhapus',
        'deskripsi' => 'Tugas ini tidak boleh ditampilkan.',
    ]);
    $tugasTerhapus->delete();

    $response = $this->withSession(['auth_id' => $user->id, 'auth_role' => 'siswa'])
        ->get(route('userSiswa.tugas'));

    $response
        ->assertOk()
        ->assertSee('Tugas Aktif')
        ->assertSee('Guru Tugas')
        ->assertSee('20/10/2026')
        ->assertSee(route('userSiswa.tugas.kerjakan', $tugas->id), false)
        ->assertDontSee('Tugas Terhapus');

    expect(substr_count($response->getContent(), 'Kerjakan'))->toBe(1);
});

it('orders tasks by newest date first', function () {
    $jurusan = jurusanModel::query()->create(['kode' => 'SORT', 'nama' => 'Sorting']);
    $kelas = kelasModel::query()->create(['nama' => 'Kelas Sorting', 'id_jurusan' => $jurusan->id]);
    $siswa = siswaModel::query()->create([
        'nis' => 'TUGAS-SORT-1',
        'nisn' => 'TUGAS-SORT-1',
        'nama' => 'Siswa Pengurut',
        'id_kelas' => $kelas->id,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $siswa->id,
        'username' => 'user-pengurut',
        'password' => 'password',
        'role' => 'siswa',
        'status' => 'active',
    ]);
    $guru = createGuruForTest([
        'nama' => 'Guru Pengampu',
    ]);
    $mapel = mapelModel::query()->create([
        'kode' => 'sort',
        'nama' => 'Mapel Urut',
        'jenis' => 'skk',
    ]);
    guruMapelKelasModel::query()->create([
        'id_guru' => $guru->id,
        'id_mapel' => $mapel->id,
        'id_kelas' => $kelas->id,
    ]);

    foreach ([
        ['tanggal' => '2026-10-20', 'judul' => 'Tugas Lama'],
        ['tanggal' => '2026-10-22', 'judul' => 'Tugas Terbaru'],
    ] as $tugasData) {
        tugasModel::query()->create([
            'id_guru' => $guru->id,
            ...$tugasData,
            'deskripsi' => 'Deskripsi tugas.',
        ]);
    }

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'siswa'])
        ->get(route('userSiswa.tugas'))
        ->assertOk()
        ->assertSeeInOrder(['22/10/2026', 'Tugas Terbaru', '20/10/2026', 'Tugas Lama']);
});

it('allows a student to submit a PDF and marks the task as completed', function () {
    Storage::fake('task_attachments');

    $guru = createGuruForTest([
        'nama' => 'Guru Pengampu',
        'username' => 'guru-pengampu',
        'password' => bcrypt('password'),
    ]);
    $jurusan = jurusanModel::query()->create(['kode' => 'RPL', 'nama' => 'Rekayasa Perangkat Lunak']);
    $kelas = kelasModel::query()->create(['nama' => 'X RPL 1', 'id_jurusan' => $jurusan->id]);
    $mapel = mapelModel::query()->create([
        'kode' => 'praktik',
        'nama' => 'Praktik',
        'jenis' => 'produktif',
    ]);
    guruMapelKelasModel::query()->create([
        'id_guru' => $guru->id,
        'id_mapel' => $mapel->id,
        'id_kelas' => $kelas->id,
    ]);
    $siswa = siswaModel::query()->create([
        'nis' => '12345',
        'nisn' => '1234567890',
        'nama' => 'Siswa Pengumpul',
        'id_kelas' => $kelas->id,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $siswa->id,
        'username' => 'siswa-pengumpul',
        'password' => bcrypt('password'),
        'role' => 'siswa',
        'status' => 'active',
    ]);
    $tugas = tugasModel::query()->create([
        'id_guru' => $guru->id,
        'tanggal' => '2026-10-20',
        'judul' => 'Laporan Praktik',
        'deskripsi' => 'Buat laporan dalam format PDF.',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'siswa'])
        ->get(route('userSiswa.tugas.kerjakan', $tugas->id))
        ->assertOk()
        ->assertSee('Belum dikerjakan');

    $this->get(route('userSiswa.tugas.kerjakan', [
        'id' => $tugas->id,
        'id_siswa' => $siswa->id,
    ]))
        ->assertOk()
        ->assertSee('Siswa Pengumpul')
        ->assertSee('Guru Pengampu')
        ->assertSee('Laporan Praktik')
        ->assertSee('Buat laporan dalam format PDF.')
        ->assertSee('Belum dikerjakan')
        ->assertSee('value="Siswa Pengumpul"', false);

    $this->from(route('userSiswa.tugas.kerjakan', $tugas->id))
        ->post(route('userSiswa.tugas.kerjakan.attempt', $tugas->id), [
            'id_siswa' => $siswa->id,
            'file' => UploadedFile::fake()->create('jawaban.txt', 10, 'text/plain'),
        ])
        ->assertRedirect(route('userSiswa.tugas.kerjakan', $tugas->id))
        ->assertSessionHasErrors('file');

    $this->assertDatabaseCount('tb_tugas_status', 0);

    $this->post(route('userSiswa.tugas.kerjakan.attempt', $tugas->id), [
        'id_siswa' => $siswa->id,
        'file' => UploadedFile::fake()->create('jawaban.pdf', 100, 'application/pdf'),
    ])
        ->assertRedirect(route('userSiswa.tugas.kerjakan', [
            'id' => $tugas->id,
        ]))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('tb_tugas_status', [
        'id_siswa' => $siswa->id,
        'id_tugas' => $tugas->id,
        'tanggal' => now()->startOfDay()->toDateTimeString(),
        'status' => 'dikerjakan',
    ]);

    $pengumpulan = DB::table('tb_tugas_status')
        ->where('id_siswa', $siswa->id)
        ->where('id_tugas', $tugas->id)
        ->first();

    expect($pengumpulan->file)
        ->toBe('Siswa Pengumpul_X RPL 1_'.now()->toDateString().'_Laporan Praktik.pdf');
    expect(Storage::disk('task_attachments')->allFiles())
        ->toContain('assets/static/tugas-pengumpulan/'.$pengumpulan->file);

    $this->get(route('userSiswa.tugas.kerjakan', [
        'id' => $tugas->id,
    ]))
        ->assertOk()
        ->assertSee('Sudah dikerjakan')
        ->assertSee(basename($pengumpulan->file))
        ->assertSee('name="file"', false)
        ->assertSee('disabled', false)
        ->assertSee('Batalkan Pengerjaan Tugas');

    $taskList = $this->get(route('userSiswa.tugas', ['id_siswa' => $siswa->id]));
    $taskList
        ->assertOk()
        ->assertSee('Laporan Praktik')
        ->assertSee(route('userSiswa.tugas.kerjakan', $tugas->id), false);

    $this->post(route('userSiswa.tugas.kerjakan.cancel', $tugas->id), [
        'id_siswa' => $siswa->id,
    ])
        ->assertRedirect(route('userSiswa.tugas.kerjakan', $tugas->id))
        ->assertSessionHas('success');

    Storage::disk('task_attachments')->assertMissing(
        'assets/static/tugas-pengumpulan/'.$pengumpulan->file,
    );
    $this->assertDatabaseHas('tb_tugas_status', [
        'id' => $pengumpulan->id,
        'status' => null,
        'file' => null,
    ]);

    $this->post(route('userSiswa.tugas.kerjakan.attempt', $tugas->id), [
        'id_siswa' => $siswa->id,
        'file' => UploadedFile::fake()->create('jawaban-baru.pdf', 100, 'application/pdf'),
    ])->assertRedirect(route('userSiswa.tugas.kerjakan', $tugas->id));

    $pengumpulanBaru = DB::table('tb_tugas_status')
        ->where('id_siswa', $siswa->id)
        ->where('id_tugas', $tugas->id)
        ->orderByDesc('id')
        ->first();

    expect($pengumpulanBaru->file)->toBe($pengumpulan->file);
    Storage::disk('task_attachments')->assertExists(
        'assets/static/tugas-pengumpulan/'.$pengumpulanBaru->file,
    );
});

it('limits task access and submissions to students in a teachers mapped class', function () {
    $jurusan = jurusanModel::query()->create(['kode' => 'AKSES', 'nama' => 'Jurusan Akses']);
    $kelasAjar = kelasModel::query()->create(['nama' => 'Kelas Ajar', 'id_jurusan' => $jurusan->id]);
    $kelasLain = kelasModel::query()->create(['nama' => 'Kelas Lain', 'id_jurusan' => $jurusan->id]);
    $guru = createGuruForTest(['nama' => 'Guru Pengampu']);
    $mapel = mapelModel::query()->create([
        'kode' => 'akses',
        'nama' => 'Mapel Akses',
        'jenis' => 'produktif',
    ]);
    guruMapelKelasModel::query()->create([
        'id_guru' => $guru->id,
        'id_mapel' => $mapel->id,
        'id_kelas' => $kelasAjar->id,
    ]);
    $siswaLain = siswaModel::query()->create([
        'nis' => 'AKSES-2',
        'nisn' => 'AKSES-2',
        'nama' => 'Siswa Kelas Lain',
        'id_kelas' => $kelasLain->id,
    ]);
    $userLain = userModel::query()->create([
        'id_user' => (string) $siswaLain->id,
        'username' => 'siswa-kelas-lain',
        'password' => 'password',
        'role' => 'siswa',
        'status' => 'active',
    ]);
    $tugas = tugasModel::query()->create([
        'id_guru' => $guru->id,
        'tanggal' => '2026-10-29',
        'judul' => 'Tugas Kelas Ajar',
        'deskripsi' => 'Tugas untuk kelas yang dipetakan.',
    ]);

    $this->withSession(['auth_id' => $userLain->id, 'auth_role' => 'siswa'])
        ->get(route('userSiswa.tugas'))
        ->assertOk()
        ->assertDontSee('Tugas Kelas Ajar');
    $this->get(route('userSiswa.tugas.kerjakan', $tugas->id))->assertNotFound();
    $this->post(route('userSiswa.tugas.kerjakan.attempt', $tugas->id), [
        'file' => UploadedFile::fake()->create('jawaban.pdf', 100, 'application/pdf'),
    ])->assertNotFound();

    $this->assertDatabaseCount('tb_tugas_status', 0);
});
