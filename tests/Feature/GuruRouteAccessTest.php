<?php

test('admin can access guru task routes', function () {
    $this->withSession([
        'auth_id' => 1,
        'auth_role' => 'admin',
    ])->get(route('tugas.add'))
        ->assertOk()
        ->assertViewIs('tugas.add');
});

test('guru can access guru task routes', function () {
    $this->withSession([
        'auth_id' => 2,
        'auth_role' => 'guru',
    ])->get(route('tugas.add'))
        ->assertOk()
        ->assertViewIs('tugas.add');
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
