<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

it('shows flash notifications as typed toasts on the login page', function () {
    $this->withSession([
        'success' => 'Login berhasil.',
        'warning' => 'Periksa kembali data Anda.',
        'failed' => 'Akses belum tersedia.',
    ])->get(route('auth'))
        ->assertOk()
        ->assertSee('data-toast-type="success"', false)
        ->assertSee('data-toast-message="Login berhasil."', false)
        ->assertSee('data-toast-type="warning"', false)
        ->assertSee('data-toast-message="Periksa kembali data Anda."', false)
        ->assertSee('data-toast-type="error"', false)
        ->assertSee('data-toast-message="Akses belum tersedia."', false);
});

it('shows flash notifications in pages that use the application layout', function () {
    Route::middleware('web')->get('/test-toast-layout', fn () => view('userSiswa.jurnal.index', [
        'jurnal' => collect(),
    ]));

    $this->withSession(['info' => 'Data berhasil dimuat.'])
        ->get('/test-toast-layout')
        ->assertOk()
        ->assertSee('data-toast-type="info"', false)
        ->assertSee('data-toast-message="Data berhasil dimuat."', false);
});

it('shows validation errors as error toasts', function () {
    $this->from(route('auth'))
        ->followingRedirects()
        ->post(route('auth.login'), [
            'username' => '',
            'password' => '',
        ])
        ->assertOk()
        ->assertSee('data-toast-type="error"', false)
        ->assertSee('data-toast-message=', false)
        ->assertSee('username', false)
        ->assertSee('password', false);
});
