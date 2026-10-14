<?php

use App\Models\tugasModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('can create, edit, download, and delete a task with its attachment', function () {
    Storage::fake('task_attachments');

    $this->get(route('tugas.add'))->assertOk();

    $this->post(route('tugas.save'), [
        'pengirim' => 'Guru A',
        'judul' => 'Matematika',
        'deskripsi' => 'Kerjakan latihan halaman 10.',
        'file' => UploadedFile::fake()->create('materi.pdf', 100, 'application/pdf'),
    ])->assertRedirect(route('tugas'));

    $tugas = tugasModel::firstOrFail();
    $firstFile = $tugas->file;

    $this->assertDatabaseHas('tb_tugas', [
        'id' => $tugas->id,
        'pengirim' => 'Guru A',
        'judul' => 'Matematika',
    ]);
    expect($firstFile)->toStartWith('assets/static/tugas/');
    $this->get(route('tugas'))->assertOk()->assertSee('Matematika');
    $this->assertTrue(Storage::disk('task_attachments')->exists($firstFile));

    $this->get(route('tugas.edit', $tugas->id))->assertOk();
    $this->get(route('tugas.file', $tugas->id))->assertOk();

    $this->put(route('tugas.update', $tugas->id), [
        'pengirim' => 'Guru B',
        'judul' => 'Matematika Revisi',
        'deskripsi' => 'Kerjakan latihan halaman 12.',
        'file' => UploadedFile::fake()->create('revisi.pdf', 100, 'application/pdf'),
    ])->assertRedirect(route('tugas'));

    $tugas->refresh();
    $secondFile = $tugas->file;

    $this->assertDatabaseHas('tb_tugas', [
        'id' => $tugas->id,
        'pengirim' => 'Guru B',
        'judul' => 'Matematika Revisi',
    ]);
    $this->assertFalse(Storage::disk('task_attachments')->exists($firstFile));
    $this->assertTrue(Storage::disk('task_attachments')->exists($secondFile));

    $this->delete(route('tugas.delete', $tugas->id))->assertRedirect(route('tugas'));

    $this->assertDatabaseMissing('tb_tugas', ['id' => $tugas->id]);
    $this->assertFalse(Storage::disk('task_attachments')->exists($secondFile));
});

it('validates required task fields and attachment type', function () {
    $this->from(route('tugas.add'))
        ->post(route('tugas.save'), [
            'pengirim' => '',
            'judul' => '',
            'deskripsi' => '',
            'file' => UploadedFile::fake()->create('script.exe', 10),
        ])
        ->assertRedirect(route('tugas.add'))
        ->assertSessionHasErrors(['pengirim', 'judul', 'deskripsi', 'file']);
});
