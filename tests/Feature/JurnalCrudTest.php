<?php

use App\Models\jurnalModel;
use App\Models\siswaModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createActiveStudent(string $name): siswaModel
{
    static $sequence = 0;
    $sequence++;

    return siswaModel::create([
        'nis' => (string) $sequence,
        'nisn' => 'NISN'.$sequence,
        'nama' => $name,
        'id_kelas' => 1,
        'username' => 'student'.$sequence,
        'password' => 'password',
        'status' => 'active',
    ]);
}

it('can create, update, and soft delete a student journal', function () {
    $siswa = createActiveStudent('Ayu Siswa');

    $this->get(route('userSiswa.jurnal.add', ['id_siswa' => $siswa->id]))
        ->assertOk()
        ->assertSee('Ayu Siswa');

    $this->post(route('userSiswa.jurnal.save'), [
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-10-22',
        'kegiatan' => 'Menyusun laporan harian.',
    ])->assertRedirect(route('userSiswa.jurnal', ['id_siswa' => $siswa->id]));

    $jurnal = jurnalModel::firstOrFail();
    $this->assertDatabaseHas('tb_jurnal', [
        'id' => $jurnal->id,
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-10-22',
        'kegiatan' => 'Menyusun laporan harian.',
    ]);

    $this->get(route('userSiswa.jurnal', ['id_siswa' => $siswa->id]))
        ->assertOk()
        ->assertSee('Menyusun laporan harian.');

    $this->put(route('userSiswa.jurnal.update', $jurnal->id), [
        'id_siswa' => $siswa->id,
        'tanggal' => '2026-10-23',
        'kegiatan' => 'Merevisi laporan harian.',
    ])->assertRedirect(route('userSiswa.jurnal', ['id_siswa' => $siswa->id]));

    $this->assertDatabaseHas('tb_jurnal', [
        'id' => $jurnal->id,
        'tanggal' => '2026-10-23',
        'kegiatan' => 'Merevisi laporan harian.',
    ]);

    $this->delete(route('userSiswa.jurnal.delete', $jurnal->id), [
        'id_siswa' => $siswa->id,
    ])->assertRedirect(route('userSiswa.jurnal', ['id_siswa' => $siswa->id]));

    $this->assertSoftDeleted('tb_jurnal', ['id' => $jurnal->id]);
});

it('does not allow a student to access another students journal', function () {
    $owner = createActiveStudent('Pemilik Jurnal');
    $otherStudent = createActiveStudent('Siswa Lain');
    $jurnal = jurnalModel::create([
        'id_siswa' => $owner->id,
        'tanggal' => '2026-10-22',
        'kegiatan' => 'Kegiatan privat siswa.',
    ]);

    $this->get(route('userSiswa.jurnal.edit', [
        'id' => $jurnal->id,
        'id_siswa' => $otherStudent->id,
    ]))->assertNotFound();

    $this->put(route('userSiswa.jurnal.update', $jurnal->id), [
        'id_siswa' => $otherStudent->id,
        'tanggal' => '2026-10-23',
        'kegiatan' => 'Mencoba mengubah jurnal siswa lain.',
    ])->assertNotFound();
});

it('validates journal date, activity, and active student', function () {
    $siswa = createActiveStudent('Siswa Aktif');

    $this->from(route('userSiswa.jurnal.add', ['id_siswa' => $siswa->id]))
        ->post(route('userSiswa.jurnal.save'), [
            'id_siswa' => $siswa->id,
            'tanggal' => 'tanggal-salah',
            'kegiatan' => '',
        ])
        ->assertRedirect(route('userSiswa.jurnal.add', ['id_siswa' => $siswa->id]))
        ->assertSessionHasErrors(['tanggal', 'kegiatan']);
});
