<?php

use App\Models\guruModel;
use App\Models\siswaModel;
use App\Models\tugasModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('shows active tasks with a kerjakan link for each task', function () {
    $guru = guruModel::query()->create([
        'nama' => 'Guru Tugas',
        'username' => 'guru-tugas',
        'password' => bcrypt('password'),
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

    $response = $this->get(route('userSiswa.tugas'));

    $response
        ->assertOk()
        ->assertSee('Tugas Aktif')
        ->assertSee('Guru Tugas')
        ->assertSee('Deskripsi tugas.')
        ->assertSee('20/10/2026')
        ->assertSee(route('userSiswa.tugas.kerjakan', $tugas->id), false)
        ->assertDontSee('Tugas Terhapus');

    expect(substr_count($response->getContent(), 'Kerjakan'))->toBe(1);
});

it('allows a student to submit a PDF and marks the task as completed', function () {
    Storage::fake('task_attachments');

    $guru = guruModel::query()->create([
        'nama' => 'Guru Pengampu',
        'username' => 'guru-pengampu',
        'password' => bcrypt('password'),
    ]);
    $siswa = siswaModel::query()->create([
        'nis' => '12345',
        'nisn' => '1234567890',
        'nama' => 'Siswa Pengumpul',
        'id_kelas' => 1,
        'username' => 'siswa-pengumpul',
        'password' => bcrypt('password'),
    ]);
    $tugas = tugasModel::query()->create([
        'id_guru' => $guru->id,
        'tanggal' => '2026-10-20',
        'judul' => 'Laporan Praktik',
        'deskripsi' => 'Buat laporan dalam format PDF.',
    ]);

    $this->get(route('userSiswa.tugas.kerjakan', $tugas->id))
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
        ->assertSee('name="id_siswa"', false)
        ->assertSee('selected>', false);

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
            'id_siswa' => $siswa->id,
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
        ->toBe('siswa-pengumpul_'.$tugas->id.'_laporan-praktik_siswa-'.$siswa->id.'.pdf');
    Storage::disk('task_attachments')->assertExists(
        'assets/static/pengumpulan-tugas/'.$pengumpulan->file,
    );

    $this->get(route('userSiswa.tugas.kerjakan', [
        'id' => $tugas->id,
        'id_siswa' => $siswa->id,
    ]))
        ->assertOk()
        ->assertSee('Dikerjakan')
        ->assertSee(basename($pengumpulan->file))
        ->assertSee('id="file" class="input" type="file" name="file" accept=".pdf,application/pdf"', false)
        ->assertSee('disabled', false)
        ->assertSee('Batalkan pengerjaan tugas');

    $taskList = $this->get(route('userSiswa.tugas', ['id_siswa' => $siswa->id]));
    $taskList
        ->assertOk()
        ->assertSee('Sudah dikerjakan')
        ->assertSee(route('userSiswa.tugas.kerjakan', [
            'id' => $tugas->id,
            'id_siswa' => $siswa->id,
        ]), false);

    $this->post(route('userSiswa.tugas.kerjakan.cancel', $tugas->id), [
        'id_siswa' => $siswa->id,
    ])
        ->assertRedirect(route('userSiswa.tugas.kerjakan', [
            'id' => $tugas->id,
            'id_siswa' => $siswa->id,
        ]))
        ->assertSessionHas('success');

    Storage::disk('task_attachments')->assertMissing($pengumpulan->file);
    $this->assertDatabaseHas('tb_tugas_status', [
        'id' => $pengumpulan->id,
        'status' => null,
        'file' => null,
    ]);

    $this->post(route('userSiswa.tugas.kerjakan.attempt', $tugas->id), [
        'id_siswa' => $siswa->id,
        'file' => UploadedFile::fake()->create('jawaban-baru.pdf', 100, 'application/pdf'),
    ])->assertRedirect(route('userSiswa.tugas.kerjakan', [
        'id' => $tugas->id,
        'id_siswa' => $siswa->id,
    ]));

    $pengumpulanBaru = DB::table('tb_tugas_status')
        ->where('id_siswa', $siswa->id)
        ->where('id_tugas', $tugas->id)
        ->first();

    expect($pengumpulanBaru->file)->toBe($pengumpulan->file);
    Storage::disk('task_attachments')->assertExists(
        'assets/static/pengumpulan-tugas/'.$pengumpulanBaru->file,
    );
});
