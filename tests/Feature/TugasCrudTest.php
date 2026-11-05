<?php

use App\Models\tugasModel;
use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('can create, update, download, and soft delete a task with its attachment', function () {
    Storage::fake('task_attachments');

    $guruPertama = createGuruForTest(['nama' => 'Guru A']);
    $guruKedua = createGuruForTest(['nama' => 'Guru B']);
    $user = userModel::query()->create([
        'id_user' => (string) $guruPertama->id,
        'username' => 'user-guru-a',
        'password' => bcrypt('password'),
        'role' => 'guru',
        'status' => 'active',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->get(route('tugas.add'))
        ->assertOk()
        ->assertViewIs('userGuru.tugas.add')
        ->assertSee('name="id_guru" value="'.$guruPertama->id.'"', false)
        ->assertSee('value="GURU A" readonly', false);

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
        ->assertViewIs('userGuru.tugas.edit')
        ->assertSee('value="GURU A" readonly', false);
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
        'id_guru' => $guruPertama->id,
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
    $guru = createGuruForTest(['nama' => 'Guru Tanpa Lampiran']);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'user-guru-tanpa-lampiran',
        'password' => bcrypt('password'),
        'role' => 'guru',
        'status' => 'active',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->post(route('tugas.save'), [
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

it('validates required task fields, date, and attachment type', function () {
    $guru = createGuruForTest(['nama' => 'Guru Aktif']);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'user-guru-aktif',
        'password' => bcrypt('password'),
        'role' => 'guru',
        'status' => 'active',
    ]);

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'guru'])
        ->from(route('tugas.add'))
        ->post(route('tugas.save'), [
            'tanggal' => 'bukan-tanggal',
            'judul' => '',
            'deskripsi' => '',
            'file' => UploadedFile::fake()->create('script.exe', 10),
        ])
        ->assertRedirect(route('tugas.add'))
        ->assertSessionHasErrors(['tanggal', 'judul', 'deskripsi', 'file']);

    $this->from(route('tugas.add'))
        ->post(route('tugas.save'), [
            'id_guru' => 999,
            'tanggal' => '2026-10-20',
            'judul' => 'Lampiran bukan PDF',
            'deskripsi' => 'Tipe lampiran tidak sesuai.',
            'file' => UploadedFile::fake()->create('materi.docx', 100),
        ])
        ->assertRedirect(route('tugas.add'))
        ->assertSessionHasErrors('file');

    $this->assertDatabaseCount('tb_tugas', 0);
});
