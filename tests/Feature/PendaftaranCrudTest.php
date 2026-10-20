<?php

use App\Models\dudiModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create, update, and soft delete a registration', function () {
    $siswaPertama = siswaModel::create([
        'nis' => 'NIS-001',
        'nisn' => 'NISN-001',
        'nama' => 'Budi Santoso',
        'id_kelas' => 1,
        'username' => 'budi',
        'password' => bcrypt('password'),
    ]);
    $siswaKedua = siswaModel::create([
        'nis' => 'NIS-002',
        'nisn' => 'NISN-002',
        'nama' => 'Siti Aminah',
        'id_kelas' => 1,
        'username' => 'siti',
        'password' => bcrypt('password'),
    ]);
    $dudiPertama = dudiModel::create([
        'nama' => 'PT Contoh',
        'alamat' => 'Jl. Merdeka',
        'telp' => '021123456',
        'pic' => 'Andi',
        'id_jurusan' => 1,
        'id_guru' => 1,
    ]);
    $dudiKedua = dudiModel::create([
        'nama' => 'CV Teknologi',
        'alamat' => 'Jl. Industri',
        'telp' => '021654321',
        'pic' => 'Rina',
        'id_jurusan' => 1,
        'id_guru' => 1,
    ]);

    $this->get(route('pendaftaran.add'))
        ->assertOk()
        ->assertSee('Budi Santoso')
        ->assertSee('PT Contoh');

    $this->post(route('pendaftaran.save'), [
        'id_siswa' => $siswaPertama->id,
        'id_dudi' => $dudiPertama->id,
    ])->assertRedirect(route('pendaftaran'));

    $pendaftaran = pendaftaranModel::query()->firstOrFail();

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaran->id,
        'id_siswa' => $siswaPertama->id,
        'id_dudi' => $dudiPertama->id,
        'status' => 'pending',
    ]);

    $this->from(route('pendaftaran.add'))
        ->post(route('pendaftaran.save'), [
            'id_siswa' => $siswaPertama->id,
            'id_dudi' => $dudiKedua->id,
        ])
        ->assertRedirect(route('pendaftaran.add'))
        ->assertSessionHasErrors('id_siswa');

    $this->get(route('pendaftaran'))
        ->assertOk()
        ->assertSee('Budi Santoso')
        ->assertSee('PT Contoh')
        ->assertSee('Setujui')
        ->assertSee('Tolak');

    $this->get(route('pendaftaran.edit', $pendaftaran->id))
        ->assertOk()
        ->assertSee('Siti Aminah')
        ->assertSee('CV Teknologi');

    $this->put(route('pendaftaran.update', $pendaftaran->id), [
        'id_siswa' => $siswaKedua->id,
        'id_dudi' => $dudiKedua->id,
    ])->assertRedirect(route('pendaftaran'));

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaran->id,
        'id_siswa' => $siswaKedua->id,
        'id_dudi' => $dudiKedua->id,
        'status' => 'pending',
    ]);

    $this->delete(route('pendaftaran.delete', $pendaftaran->id))
        ->assertRedirect(route('pendaftaran'));

    $this->assertSoftDeleted('tb_pendaftaran', ['id' => $pendaftaran->id]);
});

it('can approve or reject pending registrations only', function () {
    $makeRegistration = function (string $username, string $name): pendaftaranModel {
        $siswa = siswaModel::create([
            'nis' => "{$username}-nis",
            'nisn' => "{$username}-nisn",
            'nama' => $name,
            'id_kelas' => 1,
            'username' => $username,
            'password' => bcrypt('password'),
        ]);
        $dudi = dudiModel::create([
            'nama' => "DUDI {$name}",
            'alamat' => 'Jl. Contoh',
            'telp' => '021123456',
            'pic' => 'PIC',
            'id_jurusan' => 1,
            'id_guru' => 1,
        ]);

        return pendaftaranModel::query()->create([
            'id_siswa' => $siswa->id,
            'id_dudi' => $dudi->id,
            'status' => 'pending',
        ]);
    };

    $pendaftaranDisetujui = $makeRegistration('budi', 'Budi Santoso');
    $pendaftaranDitolak = $makeRegistration('siti', 'Siti Aminah');

    $this->patch(route('pendaftaran.status', $pendaftaranDisetujui->id), [
        'status' => 'disetujui',
    ])->assertRedirect(route('pendaftaran'));

    $this->patch(route('pendaftaran.status', $pendaftaranDitolak->id), [
        'status' => 'ditolak',
    ])->assertRedirect(route('pendaftaran'));

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaranDisetujui->id,
        'status' => 'disetujui',
    ]);
    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaranDitolak->id,
        'status' => 'ditolak',
    ]);

    $this->from(route('pendaftaran'))
        ->patch(route('pendaftaran.status', $pendaftaranDitolak->id), [
            'status' => 'pending',
        ])
        ->assertRedirect(route('pendaftaran'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaranDitolak->id,
        'status' => 'pending',
    ]);

    $this->from(route('pendaftaran'))
        ->patch(route('pendaftaran.status', $pendaftaranDisetujui->id), [
            'status' => 'ditolak',
        ])
        ->assertRedirect(route('pendaftaran'))
        ->assertSessionHas('error');

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaranDisetujui->id,
        'status' => 'disetujui',
    ]);

    $this->get(route('pendaftaran'))
        ->assertOk()
        ->assertSee('Batalkan keputusan');

    $this->patch(route('pendaftaran.status', $pendaftaranDisetujui->id), [
        'status' => 'pending',
    ])->assertRedirect(route('pendaftaran'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaranDisetujui->id,
        'status' => 'pending',
    ]);

    $this->from(route('pendaftaran'))
        ->patch(route('pendaftaran.status', $pendaftaranDisetujui->id), [
            'status' => 'invalid',
        ])
        ->assertRedirect(route('pendaftaran'))
        ->assertSessionHasErrors('status');
});

it('requires an existing student and active DUDI for a registration', function () {
    $this->from(route('pendaftaran.add'))
        ->post(route('pendaftaran.save'), [
            'id_siswa' => 999,
            'id_dudi' => 999,
        ])
        ->assertRedirect(route('pendaftaran.add'))
        ->assertSessionHasErrors(['id_siswa', 'id_dudi']);

    $this->assertDatabaseCount('tb_pendaftaran', 0);
});
