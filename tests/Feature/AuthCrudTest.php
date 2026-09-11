<?php

use App\Models\userModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a user', function () {
    $response = $this->post(route('auth.save'), [
        'nama' => 'Budi Santoso',
        'username' => 'budisantoso',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
        'role' => 'admin',
        'status' => 'active',
    ]);

    $response->assertRedirect(route('auth'));
    $this->assertDatabaseHas('tb_users', [
        'username' => 'budisantoso',
        'role' => 'admin',
    ]);
});

it('can update and delete a user', function () {
    $user = userModel::create([
        'nama' => 'Ani',
        'username' => 'ani',
        'password' => bcrypt('secret123'),
        'role' => 'siswa',
        'status' => 'active',
    ]);

    $this->put(route('auth.update', $user->id), [
        'nama' => 'Ani Updated',
        'username' => 'ani.updated',
        'role' => 'guru',
        'status' => 'inactive',
    ])->assertRedirect(route('auth'));

    $this->assertDatabaseHas('tb_users', [
        'id' => $user->id,
        'nama' => 'Ani Updated',
        'username' => 'ani.updated',
        'role' => 'guru',
        'status' => 'inactive',
    ]);

    $this->delete(route('auth.delete', $user->id))->assertRedirect(route('auth'));

    $this->assertSoftDeleted('tb_users', [
        'id' => $user->id,
    ]);
});
