<?php

use App\Models\guruModel;
use App\Models\tugasModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('can create, update, download, and soft delete a task with its attachment', function () {
    Storage::fake('task_attachments');

    $guruPertama = guruModel::query()->create([
        'nama' => 'Guru A',
        'username' => 'guru-a',
        'password' => bcrypt('password'),
    ]);
    $guruKedua = guruModel::query()->create([
        'nama' => 'Guru B',
        'username' => 'guru-b',
        'password' => bcrypt('password'),
    ]);

    $this->get(route('tugas.add'))
        ->assertOk()
        ->assertSee('type="text" name="id_guru"', false)
        ->assertSee('value="1" readonly', false);

    $this->post(route('tugas.save'), [
        'id_guru' => $guruPertama->id,
        'tanggal' => '2026-10-20',
        'judul' => 'Matematika',
        'deskripsi' => 'Kerjakan latihan halaman 10.',
        'file' => UploadedFile::fake()->create('materi.pdf', 100, 'application/pdf'),
    ])->assertRedirect(route('tugas'));

    $tugas = tugasModel::query()->firstOrFail();
    $firstFile = $tugas->file;

    $this->assertDatabaseHas('tb_tugas', [
        'id' => $tugas->id,
        'id_guru' => $guruPertama->id,
        'tanggal' => '2026-10-20 00:00:00',
        'judul' => 'Matematika',
        'deskripsi' => 'Kerjakan latihan halaman 10.',
        'file' => '2026-10-20_matematika.pdf',
    ]);
    expect($firstFile)->toBe('2026-10-20_matematika.pdf');
    Storage::disk('task_attachments')->assertExists('assets/static/tugas/'.$firstFile);

    $this->get(route('tugas'))
        ->assertOk()
        ->assertSee('Matematika')
        ->assertSee('Guru A')
        ->assertSee('20/10/2026');
    $this->get(route('tugas', ['search' => 'Guru A']))
        ->assertOk()
        ->assertSee('Matematika');
    $this->get(route('tugas.edit', $tugas->id))
        ->assertOk()
        ->assertSee('value="'.$guruPertama->id.'" readonly', false);
    $this->get(route('tugas.file', $tugas->id))->assertDownload('2026-10-20_matematika.pdf');

    $this->put(route('tugas.update', $tugas->id), [
        'id_guru' => $guruPertama->id,
        'tanggal' => '2026-10-21',
        'judul' => 'Matematika Revisi',
        'deskripsi' => 'Kerjakan latihan halaman 12.',
    ])->assertRedirect(route('tugas'));

    $tugas->refresh();
    expect($tugas->file)->toBe($firstFile);
    Storage::disk('task_attachments')->assertExists('assets/static/tugas/'.$firstFile);

    $this->put(route('tugas.update', $tugas->id), [
        'id_guru' => $guruKedua->id,
        'tanggal' => '2026-10-22',
        'judul' => 'Matematika Revisi',
        'deskripsi' => 'Kerjakan latihan halaman 12.',
        'file' => UploadedFile::fake()->create('revisi.pdf', 100, 'application/pdf'),
    ])->assertRedirect(route('tugas'));

    $tugas->refresh();
    $secondFile = $tugas->file;

    $this->assertDatabaseHas('tb_tugas', [
        'id' => $tugas->id,
        'id_guru' => $guruKedua->id,
        'tanggal' => '2026-10-22 00:00:00',
        'judul' => 'Matematika Revisi',
        'file' => '2026-10-22_matematika-revisi.pdf',
    ]);
    Storage::disk('task_attachments')->assertMissing('assets/static/tugas/'.$firstFile);
    Storage::disk('task_attachments')->assertExists('assets/static/tugas/'.$secondFile);

    $this->delete(route('tugas.delete', $tugas->id))->assertRedirect(route('tugas'));

    $this->assertSoftDeleted('tb_tugas', ['id' => $tugas->id]);
    Storage::disk('task_attachments')->assertMissing('assets/static/tugas/'.$secondFile);
});

it('allows creating a task without an optional attachment', function () {
    $guru = guruModel::query()->create([
        'nama' => 'Guru Tanpa Lampiran',
        'username' => 'guru-tanpa-lampiran',
        'password' => bcrypt('password'),
    ]);

    $this->post(route('tugas.save'), [
        'id_guru' => $guru->id,
        'tanggal' => '2026-10-20 00:00:00',
        'judul' => 'Tugas tanpa lampiran',
        'deskripsi' => 'Lampiran tidak wajib.',
    ])->assertRedirect(route('tugas'));

    $this->assertDatabaseHas('tb_tugas', [
        'id_guru' => $guru->id,
        'tanggal' => '2026-10-20 00:00:00',
        'judul' => 'Tugas tanpa lampiran',
        'file' => null,
    ]);
});

it('validates required task fields, date, active teacher, and attachment type', function () {
    guruModel::query()->create([
        'nama' => 'Guru Aktif',
        'username' => 'guru-aktif',
        'password' => bcrypt('password'),
    ]);
    $guruTerhapus = guruModel::query()->create([
        'nama' => 'Guru Terhapus',
        'username' => 'guru-terhapus',
        'password' => bcrypt('password'),
    ]);
    $guruTerhapus->delete();

    $this->from(route('tugas.add'))
        ->post(route('tugas.save'), [
            'id_guru' => '',
            'tanggal' => 'bukan-tanggal',
            'judul' => '',
            'deskripsi' => '',
            'file' => UploadedFile::fake()->create('script.exe', 10),
        ])
        ->assertRedirect(route('tugas.add'))
        ->assertSessionHasErrors(['id_guru', 'tanggal', 'judul', 'deskripsi', 'file']);

    $this->from(route('tugas.add'))
        ->post(route('tugas.save'), [
            'id_guru' => 1,
            'tanggal' => '2026-10-20',
            'judul' => 'Lampiran bukan PDF',
            'deskripsi' => 'Tipe lampiran tidak sesuai.',
            'file' => UploadedFile::fake()->create('materi.docx', 100),
        ])
        ->assertRedirect(route('tugas.add'))
        ->assertSessionHasErrors('file');

    $this->from(route('tugas.add'))
        ->post(route('tugas.save'), [
            'id_guru' => $guruTerhapus->id,
            'tanggal' => '2026-10-20',
            'judul' => 'Tugas tidak valid',
            'deskripsi' => 'Guru sudah dihapus.',
        ])
        ->assertRedirect(route('tugas.add'))
        ->assertSessionHasErrors('id_guru');
    $this->assertDatabaseCount('tb_tugas', 0);
    $this->assertDatabaseCount('tb_tugas', 0);
});
