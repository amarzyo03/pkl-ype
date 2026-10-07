<?php

use App\Imports\GuruImport;
use App\Models\guruModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('can create, update, and delete a guru account', function () {
    $this->post(route('guru.save'), [
        'nama' => 'Budi Santoso',
        'username' => 'budisantoso',
        'password' => 'guru-password-123',
        'password_confirmation' => 'guru-password-123',
    ])->assertRedirect(route('guru'));

    $guru = guruModel::where('username', 'budisantoso')->firstOrFail();

    expect(Hash::check('guru-password-123', $guru->password))->toBeTrue();

    $this->put(route('guru.update', $guru->id), [
        'nama' => 'Budi Santoso',
        'username' => 'budi.santoso',
        'password' => '',
        'password_confirmation' => '',
    ])->assertRedirect(route('guru'));

    $guru->refresh();
    expect($guru->username)->toBe('budi.santoso')
        ->and(Hash::check('guru-password-123', $guru->password))->toBeTrue();

    $this->delete(route('guru.delete', $guru->id))->assertRedirect(route('guru'));
    $this->assertSoftDeleted('tb_guru', ['id' => $guru->id]);
});

it('rejects duplicate guru usernames', function () {
    guruModel::create([
        'nama' => 'Guru Pertama',
        'username' => 'guru.sama',
        'password' => Hash::make('guru-password-123'),
    ]);

    $this->from(route('guru.add'))
        ->post(route('guru.save'), [
            'nama' => 'Guru Kedua',
            'username' => 'guru.sama',
            'password' => 'guru-password-456',
            'password_confirmation' => 'guru-password-456',
        ])
        ->assertRedirect(route('guru.add'))
        ->assertSessionHasErrors('username');
});

it('imports guru accounts with hashed passwords and preserves existing passwords when blank', function () {
    $guru = guruModel::create([
        'nama' => 'Guru Lama',
        'username' => 'guru.lama',
        'password' => Hash::make('password-lama-123'),
    ]);

    (new GuruImport)->collection(collect([
        ['nama' => 'Guru Baru', 'username' => 'guru.baru', 'password' => 'password-baru-123'],
        ['nama' => 'Guru Lama Diperbarui', 'username' => 'guru.lama', 'password' => ''],
        ['nama' => 'Tanpa Password', 'username' => 'guru.kosong', 'password' => ''],
        ['nama' => '', 'username' => 'guru.tanpa.nama', 'password' => 'password-baru-456'],
    ]));

    expect(guruModel::count())->toBe(2)
        ->and(Hash::check('password-baru-123', guruModel::where('username', 'guru.baru')->firstOrFail()->password))->toBeTrue()
        ->and(Hash::check('password-lama-123', $guru->fresh()->password))->toBeTrue()
        ->and($guru->fresh()->nama)->toBe('Guru Lama Diperbarui');
});
