<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\dashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/auth', [authController::class, 'index'])->name('auth');
Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
