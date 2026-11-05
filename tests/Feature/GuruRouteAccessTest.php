<?php

use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can access guru task routes', function () {
    $guru = createGuruForTest(['nama' => 'Guru Admin']);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'admin-guru-routes',
        'password' => 'password',
        'role' => 'admin',
        'status' => 'active',
    ]);

    $this->withSession([
        'auth_id' => $user->id,
        'auth_role' => 'admin',
    ])->get(route('tugas.add'))
        ->assertOk()
        ->assertViewIs('userGuru.tugas.add');
});

test('guru can access guru task routes', function () {
    $guru = createGuruForTest(['nama' => 'Guru Route']);
    $user = userModel::query()->create([
        'id_user' => (string) $guru->id,
        'username' => 'guru-routes',
        'password' => 'password',
        'role' => 'guru',
        'status' => 'active',
    ]);

    $this->withSession([
        'auth_id' => $user->id,
        'auth_role' => 'guru',
    ])->get(route('tugas.add'))
        ->assertOk()
        ->assertViewIs('userGuru.tugas.add');
});

test('other roles cannot access guru task routes', function () {
    $this->withSession([
        'auth_id' => 3,
        'auth_role' => 'siswa',
    ])->get(route('tugas.add'))
        ->assertRedirect(route('auth'));

    $this->get(route('tugas.add'))
        ->assertRedirect(route('auth'));
});
