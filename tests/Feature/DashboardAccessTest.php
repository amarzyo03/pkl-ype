<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

describe('admin dashboard access', function () {
    uses(RefreshDatabase::class);

    test('admin can access the dashboard', function () {
        $this->withSession([
            'auth_id' => 1,
            'auth_role' => 'admin',
        ])->get(route('dashboard'))
            ->assertOk()
            ->assertViewIs('dashboard.index');
    });
});

test('guru is redirected to the guru dashboard', function () {
    $this->withSession([
        'auth_id' => 2,
        'auth_role' => 'guru',
    ])->get(route('dashboard'))
        ->assertRedirect(route('userGuru.dashboard'));
});

test('siswa is redirected to the student dashboard', function () {
    $this->withSession([
        'auth_id' => 3,
        'auth_role' => 'siswa',
    ])->get(route('dashboard'))
        ->assertRedirect(route('userSiswa.dashboard'));
});

test('guest cannot access the admin and guru dashboard', function () {
    $this->get(route('dashboard'))
        ->assertRedirect(route('auth'));
});
