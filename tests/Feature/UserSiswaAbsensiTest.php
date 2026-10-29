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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

function createAuthenticatedAbsensiStudent(string $name): array
{
    $jurusan = jurusanModel::query()->create(['kode' => 'RPL', 'nama' => 'RPL']);
    $kelas = kelasModel::query()->create(['nama' => 'X RPL', 'id_jurusan' => $jurusan->id]);
    $siswa = siswaModel::query()->create([
        'nis' => uniqid(),
        'nisn' => uniqid(),
        'nama' => $name,
        'id_kelas' => $kelas->id,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $siswa->id,
        'username' => uniqid('student-'),
        'password' => 'password',
        'role' => 'siswa',
        'status' => 'active',
    ]);
    $guru = guruModel::query()->create(['nama' => 'Guru Absensi']);
    $dudi = dudiModel::query()->create([
        'nama' => 'PT DUDI',
        'alamat' => 'Jl. Contoh',
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

    return [$siswa, $user];
}

it('allows a student to create, view, and update their attendance', function () {
    Storage::fake('task_attachments');
    [$siswa, $user] = createAuthenticatedAbsensiStudent('Siswa Absensi');
    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'siswa']);

    $this->get(route('userSiswa.absensi.add'))
        ->assertOk()
        ->assertSee('Siswa Absensi')
        ->assertSee('value="PT DUDI"', false);

    $this->post(route('absensi.save'), [
        'tanggal' => '2026-10-28',
        'status' => 'hadir',
        'lokasi' => 'Ruang praktik',
        'keterangan' => 'Tepat waktu',
        'foto' => UploadedFile::fake()->image('hadir.jpg'),
    ])->assertRedirect(route('userSiswa.absensi'))
        ->assertSessionHas('success');

    $absensi = absensiModel::query()->firstOrFail();
    $oldPhoto = $absensi->foto;
    expect($absensi->id_siswa)->toBe($siswa->id);
    Storage::disk('task_attachments')->assertExists('assets/static/absensi/'.$oldPhoto);

    $this->get(route('userSiswa.absensi'))
        ->assertOk()
        ->assertSee('Ruang praktik')
        ->assertSee(route('absensi.edit', $absensi->id), false);

    $this->get(route('absensi.edit', $absensi->id))
        ->assertOk()
        ->assertSee('Absensi 28/10/2026');

    $this->put(route('absensi.update', $absensi->id), [
        'tanggal' => '2026-10-29',
        'status' => 'izin',
        'lokasi' => 'Rumah',
        'keterangan' => 'Ada keperluan',
        'foto' => UploadedFile::fake()->image('izin.png'),
    ])->assertRedirect(route('userSiswa.absensi'))
        ->assertSessionHas('success');

    $absensi->refresh();
    expect($absensi->status)->toBe('izin')
        ->and($absensi->lokasi)->toBe('Rumah')
        ->and($absensi->foto)->not->toBe($oldPhoto);
    Storage::disk('task_attachments')->assertMissing('assets/static/absensi/'.$oldPhoto);
    Storage::disk('task_attachments')->assertExists('assets/static/absensi/'.$absensi->foto);
});

it('prevents a student from editing another students attendance', function () {
    [$owner] = createAuthenticatedAbsensiStudent('Pemilik');
    [$otherStudent, $otherUser] = createAuthenticatedAbsensiStudent('Siswa Lain');
    $absensi = absensiModel::query()->create([
        'id_siswa' => $owner->id,
        'tanggal' => '2026-10-28',
        'status' => 'hadir',
    ]);

    $this->withSession(['auth_id' => $otherUser->id, 'auth_role' => 'siswa'])
        ->get(route('absensi.edit', $absensi->id))
        ->assertNotFound();

    $this->put(route('absensi.update', $absensi->id), [
        'tanggal' => '2026-10-29',
        'status' => 'izin',
    ])->assertNotFound();
});
