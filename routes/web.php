<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\jurusanController;
use App\Http\Controllers\siswaController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// USER
Route::get('/user', [userController::class, 'index'])->name('user');
Route::get('/user/add', [userController::class, 'add'])->name('user.add');
Route::post('/user/save', [userController::class, 'save'])->name('user.save');
Route::get('/user/edit/{id}', [userController::class, 'edit'])->name('user.edit');
Route::put('/user/update/{id}', [userController::class, 'update'])->name('user.update');
Route::delete('/user/delete/{id}', [userController::class, 'delete'])->name('user.delete');
Route::get('/user/import', [userController::class, 'import'])->name('user.import');
Route::post('/user/import', [userController::class, 'importStore'])->name('user.import.store');

// SISWA
Route::get('/siswa', [siswaController::class, 'index'])->name('siswa');
Route::get('/siswa/add', [siswaController::class, 'add'])->name('siswa.add');
Route::post('/siswa/save', [siswaController::class, 'save'])->name('siswa.save');
Route::get('/siswa/edit/{id}', [siswaController::class, 'edit'])->name('siswa.edit');
Route::put('/siswa/update/{id}', [siswaController::class, 'update'])->name('siswa.update');
Route::delete('/siswa/delete/{id}', [siswaController::class, 'delete'])->name('siswa.delete');
Route::get('/siswa/import', [siswaController::class, 'import'])->name('siswa.import');
Route::post('/siswa/import', [siswaController::class, 'importStore'])->name('siswa.import.store');

// JURUSAN
Route::get('/jurusan', [jurusanController::class, 'index'])->name('jurusan');
Route::get('/jurusan/add', [jurusanController::class, 'add'])->name('jurusan.add');
Route::post('/jurusan/save', [jurusanController::class, 'save'])->name('jurusan.save');
Route::get('/jurusan/edit/{id}', [jurusanController::class, 'edit'])->name('jurusan.edit');
Route::put('/jurusan/update/{id}', [jurusanController::class, 'update'])->name('jurusan.update');
Route::delete('/jurusan/delete/{id}', [jurusanController::class, 'delete'])->name('jurusan.delete');
Route::get('/jurusan/import', [jurusanController::class, 'import'])->name('jurusan.import');
Route::post('/jurusan/import', [jurusanController::class, 'importStore'])->name('jurusan.import.store');

Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
