<?php

use App\Models\dudiModel;
use App\Models\jurnalModel;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createAuthenticatedJournalStudent(string $name): array
{
    $jurusan = jurusanModel::query()->create([
        'kode' => uniqid('JRN'),
        'nama' => 'Jurusan Jurnal',
    ]);
    $kelas = kelasModel::query()->create([
        'nama' => 'Kelas Jurnal',
        'id_jurusan' => $jurusan->id,
    ]);
    $siswa = siswaModel::query()->create([
        'nis' => uniqid('NIS'),
        'nisn' => uniqid('NISN'),
        'nama' => $name,
        'id_kelas' => $kelas->id,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $siswa->id,
        'username' => uniqid('journal-student-'),
        'password' => 'password',
        'role' => 'siswa',
        'status' => 'active',
    ]);
    $guru = createGuruForTest(['nama' => 'Guru Jurnal']);
    $dudi = dudiModel::query()->create([
        'nama' => 'DUDI Jurnal',
        'alamat' => 'Jl. Jurnal',
        'telp' => '08000000000',
        'pic' => 'PIC Jurnal',
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

it('allows a student to create, view, update, and soft delete their journal', function () {
    [$siswa, $user] = createAuthenticatedJournalStudent('Ayu Siswa');
    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'siswa']);

    $this->get(route('userSiswa.jurnal.add'))
        ->assertOk()
        ->assertSee('max="'.now()->toDateString().'"', false)
        ->assertSee('id="nama" type="text" value="Ayu Siswa" readonly', false);

    $this->post(route('userSiswa.jurnal.save'), [
        'tanggal' => '2026-10-22',
        'kegiatan' => 'Menyusun laporan harian.',
        'id_siswa' => '9999',
    ])->assertRedirect(route('userSiswa.jurnal'))
        ->assertSessionHas('success');

    $jurnal = jurnalModel::query()->firstOrFail();
    $this->assertDatabaseHas('tb_jurnal', [
        'id' => $jurnal->id,
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-10-22',
        'kegiatan' => 'Menyusun laporan harian.',
    ]);

    $this->get(route('userSiswa.jurnal'))
        ->assertOk()
        ->assertSee('Menyusun laporan harian.');

    $this->put(route('userSiswa.jurnal.update', $jurnal->id), [
        'tanggal' => '2026-10-23',
        'kegiatan' => 'Merevisi laporan harian.',
    ])->assertRedirect(route('userSiswa.jurnal'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('tb_jurnal', [
        'id' => $jurnal->id,
        'tanggal' => '2026-10-23',
        'kegiatan' => 'Merevisi laporan harian.',
    ]);

    $this->delete(route('userSiswa.jurnal.delete', $jurnal->id))
        ->assertRedirect(route('userSiswa.jurnal'))
        ->assertSessionHas('success');

    $this->assertSoftDeleted('tb_jurnal', ['id' => $jurnal->id]);
});

it('does not allow a student to access another students journal', function () {
    [$owner] = createAuthenticatedJournalStudent('Pemilik Jurnal');
    [$otherStudent, $otherUser] = createAuthenticatedJournalStudent('Siswa Lain');
    $jurnal = jurnalModel::query()->create([
        'id_siswa' => $owner->id,
        'tanggal' => '2026-10-22',
        'kegiatan' => 'Kegiatan privat siswa.',
    ]);
    $this->withSession(['auth_id' => $otherUser->id, 'auth_role' => 'siswa']);

    $this->get(route('userSiswa.jurnal.edit', $jurnal->id))
        ->assertNotFound();

    $this->put(route('userSiswa.jurnal.update', $jurnal->id), [
        'tanggal' => '2026-10-23',
        'kegiatan' => 'Mencoba mengubah jurnal siswa lain.',
    ])->assertNotFound();

    $this->delete(route('userSiswa.jurnal.delete', $jurnal->id))
        ->assertNotFound();

    expect($otherStudent->id)->not->toBe($owner->id);
});

it('validates journal date and activity', function () {
    [, $user] = createAuthenticatedJournalStudent('Siswa Aktif');
    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'siswa']);

    $this->from(route('userSiswa.jurnal.add'))
        ->post(route('userSiswa.jurnal.save'), [
            'tanggal' => 'tanggal-salah',
            'kegiatan' => '',
        ])
        ->assertRedirect(route('userSiswa.jurnal.add'))
        ->assertSessionHasErrors(['tanggal', 'kegiatan']);

    $this->post(route('userSiswa.jurnal.save'), [
        'tanggal' => now()->addDay()->toDateString(),
        'kegiatan' => 'Kegiatan tanggal mendatang.',
    ])->assertSessionHasErrors('tanggal');
});
