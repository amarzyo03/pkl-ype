<?php

use App\Models\dudiModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin']);
});

it('can create, update, and soft delete a registration', function () {
    $siswaPertama = siswaModel::create([
        'nis' => 'NIS-001',
        'nisn' => 'NISN-001',
        'nama' => 'Budi Santoso',
        'id_kelas' => 1,
    ]);
    $siswaKedua = siswaModel::create([
        'nis' => 'NIS-002',
        'nisn' => 'NISN-002',
        'nama' => 'Siti Aminah',
        'id_kelas' => 1,
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
        ->assertSee('id="id_siswa" class="select" name="id_siswa"', false)
        ->assertSee('Budi Santoso (NIS-001)')
        ->assertSee('Siti Aminah (NIS-002)')
        ->assertSee('id="status" class="select" name="status"', false)
        ->assertSee('PT Contoh');

    $this->post(route('pendaftaran.save'), [
        'id_siswa' => $siswaPertama->id,
        'id_dudi' => $dudiPertama->id,
        'status' => 'disetujui',
    ])->assertRedirect(route('pendaftaran'));

    $pendaftaran = pendaftaranModel::query()->firstOrFail();

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaran->id,
        'id_siswa' => $siswaPertama->id,
        'id_dudi' => $dudiPertama->id,
        'status' => 'disetujui',
    ]);

    $this->from(route('pendaftaran.add'))
        ->post(route('pendaftaran.save'), [
            'id_siswa' => $siswaPertama->id,
            'id_dudi' => $dudiKedua->id,
            'status' => 'pending',
        ])
        ->assertRedirect(route('pendaftaran.add'))
        ->assertSessionHasErrors('id_siswa');

    $this->get(route('pendaftaran'))
        ->assertOk()
        ->assertSee('Budi Santoso')
        ->assertSee('PT Contoh')
        ->assertSee('id="select-all-pendaftaran"', false)
        ->assertSee('form="bulk-registration-status"', false)
        ->assertSee('Konfirmasi yang dicentang')
        ->assertSee('Batalkan keputusan');

    $this->get(route('pendaftaran.edit', $pendaftaran->id))
        ->assertOk()
        ->assertSee('value="'.$siswaPertama->id.'" selected', false)
        ->assertSee('CV Teknologi');

    $this->put(route('pendaftaran.update', $pendaftaran->id), [
        'id_siswa' => $siswaKedua->id,
        'id_dudi' => $dudiKedua->id,
        'status' => 'ditolak',
    ])->assertRedirect(route('pendaftaran'));

    $this->assertDatabaseHas('tb_pendaftaran', [
        'id' => $pendaftaran->id,
        'id_siswa' => $siswaKedua->id,
        'id_dudi' => $dudiKedua->id,
        'status' => 'ditolak',
    ]);

    $this->delete(route('pendaftaran.delete', $pendaftaran->id))
        ->assertRedirect(route('pendaftaran'));

    $this->assertSoftDeleted('tb_pendaftaran', ['id' => $pendaftaran->id]);
    $this->get(route('pendaftaran.add'))
        ->assertOk()
        ->assertDontSee('Siti Aminah (NIS-002)');
});

it('renders registration list partials for ajax requests', function () {
    $siswa = siswaModel::create([
        'nis' => 'NIS-003',
        'nisn' => 'NISN-003',
        'nama' => 'Rina Lestari',
        'id_kelas' => 1,
    ]);
    $dudi = dudiModel::create([
        'nama' => 'PT Contoh',
        'alamat' => 'Jl. Merdeka',
        'telp' => '021123456',
        'pic' => 'Andi',
        'id_jurusan' => 1,
        'id_guru' => 1,
    ]);

    pendaftaranModel::query()->create([
        'id_siswa' => $siswa->id,
        'id_dudi' => $dudi->id,
        'status' => 'pending',
    ]);

    $response = $this->get(route('pendaftaran', [
        'search' => 'Rina',
        'perPage' => 25,
        'ajax' => 1,
    ]));

    $response->assertOk()
        ->assertJsonStructure(['rows', 'summary', 'pager']);

    expect($response->json('rows'))
        ->toContain('Rina Lestari')
        ->toContain('form="bulk-registration-status"')
        ->and($response->json('summary'))
        ->toContain('1–1 dari')
        ->toContain('1 pendaftaran')
        ->toContain('25 per halaman');
});

it('can approve or reject pending registrations only', function () {
    $makeRegistration = function (string $username, string $name): pendaftaranModel {
        $siswa = siswaModel::create([
            'nis' => "{$username}-nis",
            'nisn' => "{$username}-nisn",
            'nama' => $name,
            'id_kelas' => 1,
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
            'status' => 'pending',
        ])
        ->assertRedirect(route('pendaftaran.add'))
        ->assertSessionHasErrors(['id_siswa', 'id_dudi']);

    $this->assertDatabaseCount('tb_pendaftaran', 0);
});

it('updates only the selected registrations in bulk', function () {
    $makeRegistration = function (string $username, string $name): pendaftaranModel {
        $siswa = siswaModel::query()->create([
            'nis' => "{$username}-nis",
            'nisn' => "{$username}-nisn",
            'nama' => $name,
            'id_kelas' => 1,
        ]);
        $dudi = dudiModel::query()->create([
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

    $first = $makeRegistration('bulk-one', 'Siswa Pertama');
    $second = $makeRegistration('bulk-two', 'Siswa Kedua');
    $unselected = $makeRegistration('bulk-three', 'Siswa Ketiga');

    $this->patch(route('pendaftaran.status.bulk'), [
        'pendaftaran_ids' => [$first->id, $second->id],
        'status' => 'disetujui',
    ])->assertRedirect(route('pendaftaran'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('tb_pendaftaran', ['id' => $first->id, 'status' => 'disetujui']);
    $this->assertDatabaseHas('tb_pendaftaran', ['id' => $second->id, 'status' => 'disetujui']);
    $this->assertDatabaseHas('tb_pendaftaran', ['id' => $unselected->id, 'status' => 'pending']);

    $this->from(route('pendaftaran'))
        ->patch(route('pendaftaran.status.bulk'), [
            'pendaftaran_ids' => [],
            'status' => 'ditolak',
        ])
        ->assertRedirect(route('pendaftaran'))
        ->assertSessionHasErrors('pendaftaran_ids');
});
