<?php

use App\Models\siswaModel;
use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('allows a student to open the dashboard on first login when user and student ids differ', function () {
    siswaModel::query()->create([
        'nis' => '1000',
        'nisn' => '2000',
        'nama' => 'Siswa Lain',
        'id_kelas' => 1,
    ]);

    $siswa = siswaModel::query()->create([
        'nis' => '1001',
        'nisn' => '2001',
        'nama' => 'Siswa Baru',
        'id_kelas' => 1,
    ]);
    $user = userModel::query()->create([
        'id_user' => (string) $siswa->id,
        'username' => 'siswa-baru',
        'password' => Hash::make('secret123'),
        'role' => 'siswa',
        'status' => 'active',
    ]);

    expect($user->id)->not->toBe($siswa->id);

    $this->post(route('auth.login'), [
        'username' => 'siswa-baru',
        'password' => 'secret123',
    ])->assertRedirect(route('userSiswa.dashboard'));

    $this->get(route('userSiswa.dashboard'))->assertOk();
});
