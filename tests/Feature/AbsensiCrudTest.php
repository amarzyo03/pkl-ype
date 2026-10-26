<?php

use App\Models\absensiModel;
use App\Models\siswaModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

function createAbsensiActiveStudent(string $name): siswaModel
{
    static $sequence = 0;
    $sequence++;

    return siswaModel::query()->create([
        'nis' => (string) $sequence,
        'nisn' => 'ABSENSI'.$sequence,
        'nama' => $name,
        'id_kelas' => 1,
        'username' => 'absensi-student-'.$sequence,
        'password' => 'password',
        'status' => 'active',
    ]);
}

it('can create, update, and soft delete a student attendance with its photo', function () {
    Storage::fake('task_attachments');
    $siswa = createAbsensiActiveStudent('Ayu Absensi');

    $this->get(route('absensi.add', ['id_siswa' => $siswa->id]))
        ->assertOk()
        ->assertSee('Ayu Absensi');

    $this->post(route('absensi.save'), [
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-10-22',
        'status' => 'hadir',
        'lokasi' => 'Ruang praktik',
        'keterangan' => 'Tepat waktu',
        'foto' => UploadedFile::fake()->image('hadir.jpg'),
    ])->assertRedirect(route('absensi', ['id_siswa' => $siswa->id]));

    $absensi = absensiModel::query()->firstOrFail();
    $oldPhoto = $absensi->foto;

    $this->assertDatabaseHas('tb_absensi', [
        'id' => $absensi->id,
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-10-22',
        'status' => 'hadir',
        'lokasi' => 'Ruang praktik',
        'keterangan' => 'Tepat waktu',
        'foto' => $oldPhoto,
    ]);
    Storage::disk('task_attachments')->assertExists('assets/static/absensi/'.$oldPhoto);

    $this->get(route('absensi', ['id_siswa' => $siswa->id]))
        ->assertOk()
        ->assertSee('Ayu Absensi')
        ->assertSee('Ruang praktik');
    $this->get(route('absensi.edit', ['id' => $absensi->id, 'id_siswa' => $siswa->id]))
        ->assertOk()
        ->assertSee('Ayu Absensi');

    $this->put(route('absensi.update', $absensi->id), [
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-10-23',
        'status' => 'izin',
        'lokasi' => 'Rumah',
        'keterangan' => 'Ada keperluan keluarga',
    ])->assertRedirect(route('absensi', ['id_siswa' => $siswa->id]));

    $absensi->refresh();
    expect($absensi->status)->toBe('izin')
        ->and($absensi->foto)->toBe($oldPhoto);
    Storage::disk('task_attachments')->assertExists('assets/static/absensi/'.$oldPhoto);

    $this->put(route('absensi.update', $absensi->id), [
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-10-23',
        'status' => 'izin',
        'lokasi' => 'Rumah',
        'keterangan' => 'Ada keperluan keluarga',
        'foto' => UploadedFile::fake()->image('izin.png'),
    ])->assertRedirect(route('absensi', ['id_siswa' => $siswa->id]));

    $absensi->refresh();
    expect($absensi->foto)->not->toBe($oldPhoto);
    Storage::disk('task_attachments')->assertMissing('assets/static/absensi/'.$oldPhoto);
    Storage::disk('task_attachments')->assertExists('assets/static/absensi/'.$absensi->foto);

    $this->delete(route('absensi.delete', $absensi->id), [
        'id_siswa' => $siswa->id,
    ])->assertRedirect(route('absensi', ['id_siswa' => $siswa->id]));

    $this->assertSoftDeleted('tb_absensi', ['id' => $absensi->id]);
    Storage::disk('task_attachments')->assertMissing('assets/static/absensi/'.$absensi->foto);
});

it('does not allow a student to access another students attendance', function () {
    $owner = createAbsensiActiveStudent('Pemilik Absensi');
    $otherStudent = createAbsensiActiveStudent('Siswa Lain');
    $absensi = absensiModel::query()->create([
        'id_siswa' => $owner->id,
        'tanggal' => '2026-10-22',
        'status' => 'hadir',
    ]);

    $this->get(route('absensi.edit', [
        'id' => $absensi->id,
        'id_siswa' => $otherStudent->id,
    ]))->assertNotFound();

    $this->put(route('absensi.update', $absensi->id), [
        'id_siswa' => $otherStudent->id,
        'tanggal' => '2026-10-23',
        'status' => 'izin',
    ])->assertNotFound();

    $this->delete(route('absensi.delete', $absensi->id), [
        'id_siswa' => $otherStudent->id,
    ])->assertNotFound();
});

it('validates attendance date, status, student, and photo', function () {
    $siswa = createAbsensiActiveStudent('Siswa Aktif');

    $this->from(route('absensi.add', ['id_siswa' => $siswa->id]))
        ->post(route('absensi.save'), [
            'id_siswa' => $siswa->id,
            'tanggal' => 'tanggal-salah',
            'status' => 'status-salah',
            'foto' => UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf'),
        ])
        ->assertRedirect(route('absensi.add', ['id_siswa' => $siswa->id]))
        ->assertSessionHasErrors(['tanggal', 'status', 'foto']);

    $siswa->delete();

    $this->from(route('absensi.add', ['id_siswa' => $siswa->id]))
        ->post(route('absensi.save'), [
            'id_siswa' => $siswa->id,
            'tanggal' => '2026-10-22',
            'status' => 'hadir',
        ])
        ->assertRedirect(route('absensi.add', ['id_siswa' => $siswa->id]))
        ->assertSessionHasErrors('id_siswa');

    $this->assertDatabaseCount('tb_absensi', 0);
});
