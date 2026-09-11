<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\guruController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/auth', [authController::class, 'index'])->name('auth');
Route::get('/auth/add', [authController::class, 'add'])->name('auth.add');
Route::post('/auth/save', [authController::class, 'save'])->name('auth.save');
Route::get('/auth/edit/{id}', [authController::class, 'edit'])->name('auth.edit');
Route::put('/auth/update/{id}', [authController::class, 'update'])->name('auth.update');
Route::delete('/auth/delete/{id}', [authController::class, 'delete'])->name('auth.delete');
Route::get('/auth/import', [authController::class, 'import'])->name('auth.import');
Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
