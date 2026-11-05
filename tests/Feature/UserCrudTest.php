<?php

use App\Models\kelasModel;
use App\Models\siswaModel;
use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('creates a guru login linked to the selected guru profile', function () {
    $guru = createGuruForTest(['nama' => 'Guru Pilihan']);

    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin'])
        ->get(route('user.add'))
        ->assertOk()
        ->assertSee('Guru Pilihan')
        ->assertSee('TEST-GURU - Jurusan Guru Test')
        ->assertSee('Pilih guru');

    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin'])
        ->post(route('user.save'), [
            'id_guru' => $guru->id,
            'username' => 'guru.pilihan',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'guru',
            'status' => 'active',
        ])
        ->assertRedirect(route('user'));

    $account = userModel::query()->where('username', 'guru.pilihan')->firstOrFail();

    expect($account->id_user)->toBe((string) $guru->id)
        ->and($account->role)->toBe('guru')
        ->and(Hash::check('secret123', $account->password))->toBeTrue();
});

it('only lists guru profiles without an existing login account', function () {
    $availableGuru = createGuruForTest(['nama' => 'Guru Belum Punya Akun']);
    $guruWithAccount = createGuruForTest(['nama' => 'Guru Sudah Ada Akun']);
    $adminGuruWithAccount = createGuruForTest(['nama' => 'Guru Akun Admin']);

    userModel::query()->create([
        'id_user' => (string) $guruWithAccount->id,
        'username' => 'guru.sudah.ada',
        'password' => Hash::make('secret123'),
        'role' => 'guru',
        'status' => 'active',
    ]);
    userModel::query()->create([
        'id_user' => (string) $adminGuruWithAccount->id,
        'username' => 'admin.guru',
        'password' => Hash::make('secret123'),
        'role' => 'admin',
        'status' => 'active',
    ]);

    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin'])
        ->get(route('user.add'))
        ->assertOk()
        ->assertSee('Guru Belum Punya Akun')
        ->assertDontSee('Guru Sudah Ada Akun')
        ->assertDontSee('Guru Akun Admin');

    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin'])
        ->from(route('user.add'))
        ->post(route('user.save'), [
            'id_guru' => $guruWithAccount->id,
            'username' => 'guru.duplikat',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'guru',
            'status' => 'active',
        ])
        ->assertRedirect(route('user.add'))
        ->assertSessionHasErrors('id_guru');

    expect(userModel::query()->where('username', 'guru.duplikat')->exists())->toBeFalse();
});

it('requires a valid guru profile for guru accounts', function () {
    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin'])
        ->from(route('user.add'))
        ->post(route('user.save'), [
            'id_guru' => 999,
            'username' => 'guru.invalid',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'guru',
            'status' => 'active',
        ])
        ->assertRedirect(route('user.add'))
        ->assertSessionHasErrors('id_guru');

    expect(userModel::query()->where('username', 'guru.invalid')->exists())->toBeFalse();
});

it('updates the selected guru profile without replacing an unchanged password', function () {
    $firstGuru = createGuruForTest(['nama' => 'Guru Lama']);
    $selectedGuru = createGuruForTest(['nama' => 'Guru Baru']);
    $account = userModel::query()->create([
        'id_user' => (string) $firstGuru->id,
        'username' => 'guru.lama',
        'password' => Hash::make('secret123'),
        'role' => 'guru',
        'status' => 'active',
    ]);

    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin'])
        ->get(route('user.edit', $account->id))
        ->assertOk()
        ->assertSee('Guru Lama')
        ->assertSee('TEST-GURU - Jurusan Guru Test')
        ->assertSee('Pilih guru');

    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin'])
        ->put(route('user.update', $account->id), [
            'id_guru' => $selectedGuru->id,
            'username' => 'guru.baru',
            'password' => '',
            'password_confirmation' => '',
            'role' => 'guru',
            'status' => 'active',
        ])
        ->assertRedirect(route('user'));

    $account->refresh();
    expect($account->id_user)->toBe((string) $selectedGuru->id)
        ->and($account->username)->toBe('guru.baru')
        ->and(Hash::check('secret123', $account->password))->toBeTrue();
});

it('shows and searches users using their linked guru name', function () {
    $guru = createGuruForTest(['nama' => 'Guru Terhubung']);
    userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru.terhubung',
        'password' => Hash::make('secret123'),
        'role' => 'guru',
        'status' => 'active',
    ]);

    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin'])
        ->get(route('user', ['search' => 'Guru Terhubung']))
        ->assertOk()
        ->assertSee('Guru Terhubung')
        ->assertSee('guru.terhubung');
});

it('uses the profile that matches the account role when profile ids overlap', function () {
    $guru = createGuruForTest(['nama' => 'Guru Profile']);
    $kelas = kelasModel::query()->create([
        'nama' => 'Kelas Profil Test',
        'id_jurusan' => $guru->id_jurusan,
    ]);
    $siswa = siswaModel::query()->create([
        'nis' => 'SISWA-TEST',
        'nisn' => 'SISWA-TEST-1',
        'nama' => 'Siswa Profile',
        'id_kelas' => $kelas->id,
        'status' => 'active',
    ]);

    expect($guru->id)->toBe($siswa->id);

    userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru.profile',
        'password' => Hash::make('secret123'),
        'role' => 'guru',
        'status' => 'active',
    ]);
    userModel::query()->create([
        'id_user' => (string) $siswa->id,
        'username' => 'siswa.profile',
        'password' => Hash::make('secret123'),
        'role' => 'siswa',
        'status' => 'active',
    ]);

    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin'])
        ->get(route('user', ['search' => 'Guru Profile']))
        ->assertOk()
        ->assertSee('Guru Profile')
        ->assertSee('guru.profile')
        ->assertDontSee('siswa.profile');

    $this->withSession(['auth_id' => 1, 'auth_role' => 'admin'])
        ->get(route('user', ['search' => 'Siswa Profile']))
        ->assertOk()
        ->assertSee('Siswa Profile')
        ->assertSee('siswa.profile')
        ->assertDontSee('guru.profile');
});
