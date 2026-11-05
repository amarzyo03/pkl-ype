<?php

use App\Models\dudiModel;
use App\Models\jurusanModel;
use App\Models\kelasModel;
use App\Models\pendaftaranModel;
use App\Models\siswaModel;
use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createStudentWithRegistrationStatus(string $status): userModel
{
    $jurusan = jurusanModel::query()->create([
        'kode' => 'ACCESS',
        'nama' => 'Jurusan Akses',
    ]);
    $kelas = kelasModel::query()->create([
        'nama' => 'Kelas Akses',
        'id_jurusan' => $jurusan->id,
    ]);
    $guru = createGuruForTest(['nama' => 'Guru Akses']);
    $dudi = dudiModel::query()->create([
        'nama' => 'DUDI Akses',
        'alamat' => 'Jl. Akses',
        'telp' => '08000000000',
        'pic' => 'PIC Akses',
        'id_jurusan' => $jurusan->id,
        'id_guru' => $guru->id,
    ]);
    $siswa = siswaModel::query()->create([
        'nis' => 'ACCESS-001',
        'nisn' => 'ACCESS-001',
        'nama' => 'Siswa Akses',
        'id_kelas' => $kelas->id,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $siswa->id,
        'username' => 'siswa-akses',
        'password' => 'password',
        'role' => 'siswa',
        'status' => 'active',
    ]);
    pendaftaranModel::query()->create([
        'id_siswa' => (string) $siswa->id,
        'id_dudi' => (string) $dudi->id,
        'status' => $status,
    ]);

    return $user;
}

it('redirects students with pending or rejected registration from attendance journals and tasks', function (string $status) {
    $user = createStudentWithRegistrationStatus($status);
    $session = ['auth_id' => $user->id, 'auth_role' => 'siswa'];

    foreach ([
        ['GET', route('userSiswa.absensi')],
        ['GET', route('userSiswa.jurnal')],
        ['GET', route('userSiswa.tugas')],
        ['POST', route('absensi.save')],
        ['POST', route('userSiswa.tugas.kerjakan.attempt', 1)],
        ['DELETE', route('userSiswa.jurnal.delete', 1)],
    ] as [$method, $url]) {
        $this->withSession($session)
            ->call($method, $url)
            ->assertRedirect(route('userSiswa.pendaftaran.status'))
            ->assertSessionHas('failed', 'Akses tersedia setelah pendaftaran PKL disetujui.');
    }

    $this->withSession($session)
        ->post(route('userSiswa.jurnal.save'), [
            'tanggal' => now()->toDateString(),
            'kegiatan' => 'Kegiatan yang tidak boleh tersimpan',
        ])
        ->assertRedirect(route('userSiswa.pendaftaran.status'));
    $this->get(route('userSiswa.pendaftaran.status'))
        ->assertOk()
        ->assertSee('Akses tersedia setelah pendaftaran PKL disetujui.')
        ->assertSee($status === 'ditolak' ? 'badge danger dot' : 'badge warning dot', false);

    $this->assertDatabaseCount('tb_jurnal', 0);
    $this->assertDatabaseCount('tb_absensi', 0);
    $this->assertDatabaseCount('tb_tugas_status', 0);
})->with([
    'pending registration' => 'pending',
    'rejected registration' => 'ditolak',
]);

it('redirects a student without a registration to the registration page', function () {
    $user = createStudentWithRegistrationStatus('pending');
    pendaftaranModel::query()->delete();

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'siswa'])
        ->get(route('userSiswa.jurnal'))
        ->assertRedirect(route('userSiswa.pendaftaran'));
});

it('allows access to attendance journals and tasks after registration is approved', function () {
    $user = createStudentWithRegistrationStatus('disetujui');

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'siswa'])
        ->get(route('userSiswa.absensi'))
        ->assertOk();

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'siswa'])
        ->get(route('userSiswa.jurnal'))
        ->assertOk();

    $this->withSession(['auth_id' => $user->id, 'auth_role' => 'siswa'])
        ->get(route('userSiswa.tugas'))
        ->assertOk();
});
