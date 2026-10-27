<?php

test('admin can access the dashboard', function () {
    $this->withSession([
        'auth_id' => 1,
        'auth_role' => 'admin',
    ])->get(route('dashboard'))
        ->assertOk()
        ->assertViewIs('dashboard.index');
});

test('guru can access the dashboard', function () {
    $this->withSession([
        'auth_id' => 2,
        'auth_role' => 'guru',
    ])->get(route('dashboard'))
        ->assertOk()
        ->assertViewIs('dashboard.index')
        ->assertSee('data-role="guru"', false);
});

test('siswa cannot access the admin and guru dashboard', function () {
    $this->withSession([
        'auth_id' => 3,
        'auth_role' => 'siswa',
    ])->get(route('dashboard'))
        ->assertRedirect(route('auth'));
});

test('guest cannot access the admin and guru dashboard', function () {
    $this->get(route('dashboard'))
        ->assertRedirect(route('auth'));
});
