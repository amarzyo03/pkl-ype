<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\dudiController;
use App\Http\Controllers\guruController;
use App\Http\Controllers\jurusanController;
use App\Http\Controllers\kelasController;
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

// KELAS
Route::get('/kelas', [kelasController::class, 'index'])->name('kelas');
Route::get('/kelas/add', [kelasController::class, 'add'])->name('kelas.add');
Route::post('/kelas/save', [kelasController::class, 'save'])->name('kelas.save');
Route::get('/kelas/edit/{id}', [kelasController::class, 'edit'])->name('kelas.edit');
Route::put('/kelas/update/{id}', [kelasController::class, 'update'])->name('kelas.update');
Route::delete('/kelas/delete/{id}', [kelasController::class, 'delete'])->name('kelas.delete');
Route::get('/kelas/import', [kelasController::class, 'import'])->name('kelas.import');
Route::post('/kelas/import', [kelasController::class, 'importStore'])->name('kelas.import.store');

// DUDI
Route::get('/dudi', [dudiController::class, 'index'])->name('dudi');
Route::get('/dudi/add', [dudiController::class, 'add'])->name('dudi.add');
Route::post('/dudi/save', [dudiController::class, 'save'])->name('dudi.save');
Route::get('/dudi/edit/{id}', [dudiController::class, 'edit'])->name('dudi.edit');
Route::put('/dudi/update/{id}', [dudiController::class, 'update'])->name('dudi.update');
Route::delete('/dudi/delete/{id}', [dudiController::class, 'delete'])->name('dudi.delete');
Route::get('/dudi/import', [dudiController::class, 'import'])->name('dudi.import');
Route::post('/dudi/import', [dudiController::class, 'importStore'])->name('dudi.import.store');

// GURU
Route::get('/guru', [guruController::class, 'index'])->name('guru');
Route::get('/guru/add', [guruController::class, 'add'])->name('guru.add');
Route::post('/guru/save', [guruController::class, 'save'])->name('guru.save');
Route::get('/guru/edit/{id}', [guruController::class, 'edit'])->name('guru.edit');
Route::put('/guru/update/{id}', [guruController::class, 'update'])->name('guru.update');
Route::delete('/guru/delete/{id}', [guruController::class, 'delete'])->name('guru.delete');
Route::get('/guru/import', [guruController::class, 'import'])->name('guru.import');
Route::post('/guru/import', [guruController::class, 'importStore'])->name('guru.import.store');

Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
