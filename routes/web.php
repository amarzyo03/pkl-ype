<?php

use App\Http\Controllers\absensiController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\dudiController;
use App\Http\Controllers\guruController;
use App\Http\Controllers\jurusanController;
use App\Http\Controllers\kelasController;
use App\Http\Controllers\pendaftaranController;
use App\Http\Controllers\siswaController;
use App\Http\Controllers\tugasController;
use App\Http\Controllers\userController;
use App\Http\Controllers\userSiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ===== ADMIN ===== ##
// DASHBOARD
Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');

// PENDAFTARAN
Route::get('/pendaftaran', [pendaftaranController::class, 'index'])->name('pendaftaran');
Route::get('/pendaftaran/add', [pendaftaranController::class, 'add'])->name('pendaftaran.add');
Route::post('/pendaftaran/save', [pendaftaranController::class, 'save'])->name('pendaftaran.save');
Route::get('/pendaftaran/edit/{id}', [pendaftaranController::class, 'edit'])->name('pendaftaran.edit');
Route::put('/pendaftaran/update/{id}', [pendaftaranController::class, 'update'])->name('pendaftaran.update');
Route::delete('/pendaftaran/delete/{id}', [pendaftaranController::class, 'delete'])->name('pendaftaran.delete');
Route::patch('/pendaftaran/{id}/status', [pendaftaranController::class, 'updateStatus'])->name('pendaftaran.status');

// DUDI
Route::get('/dudi', [dudiController::class, 'index'])->name('dudi');
Route::get('/dudi/add', [dudiController::class, 'add'])->name('dudi.add');
Route::post('/dudi/save', [dudiController::class, 'save'])->name('dudi.save');
Route::get('/dudi/edit/{id}', [dudiController::class, 'edit'])->name('dudi.edit');
Route::put('/dudi/update/{id}', [dudiController::class, 'update'])->name('dudi.update');
Route::delete('/dudi/delete/{id}', [dudiController::class, 'delete'])->name('dudi.delete');
Route::get('/dudi/import', [dudiController::class, 'import'])->name('dudi.import');
Route::post('/dudi/import', [dudiController::class, 'importStore'])->name('dudi.import.store');

// SISWA
Route::get('/siswa', [siswaController::class, 'index'])->name('siswa');
Route::get('/siswa/add', [siswaController::class, 'add'])->name('siswa.add');
Route::post('/siswa/save', [siswaController::class, 'save'])->name('siswa.save');
Route::get('/siswa/edit/{id}', [siswaController::class, 'edit'])->name('siswa.edit');
Route::put('/siswa/update/{id}', [siswaController::class, 'update'])->name('siswa.update');
Route::delete('/siswa/delete/{id}', [siswaController::class, 'delete'])->name('siswa.delete');
Route::get('/siswa/import', [siswaController::class, 'import'])->name('siswa.import');
Route::post('/siswa/import', [siswaController::class, 'importStore'])->name('siswa.import.store');

// GURU
Route::get('/guru', [guruController::class, 'index'])->name('guru');
Route::get('/guru/add', [guruController::class, 'add'])->name('guru.add');
Route::post('/guru/save', [guruController::class, 'save'])->name('guru.save');
Route::get('/guru/edit/{id}', [guruController::class, 'edit'])->name('guru.edit');
Route::put('/guru/update/{id}', [guruController::class, 'update'])->name('guru.update');
Route::delete('/guru/delete/{id}', [guruController::class, 'delete'])->name('guru.delete');
Route::get('/guru/import', [guruController::class, 'import'])->name('guru.import');
Route::post('/guru/import', [guruController::class, 'importStore'])->name('guru.import.store');

// KELAS
Route::get('/kelas', [kelasController::class, 'index'])->name('kelas');
Route::get('/kelas/add', [kelasController::class, 'add'])->name('kelas.add');
Route::post('/kelas/save', [kelasController::class, 'save'])->name('kelas.save');
Route::get('/kelas/edit/{id}', [kelasController::class, 'edit'])->name('kelas.edit');
Route::put('/kelas/update/{id}', [kelasController::class, 'update'])->name('kelas.update');
Route::delete('/kelas/delete/{id}', [kelasController::class, 'delete'])->name('kelas.delete');
Route::get('/kelas/import', [kelasController::class, 'import'])->name('kelas.import');
Route::post('/kelas/import', [kelasController::class, 'importStore'])->name('kelas.import.store');

// JURUSAN
Route::get('/jurusan', [jurusanController::class, 'index'])->name('jurusan');
Route::get('/jurusan/add', [jurusanController::class, 'add'])->name('jurusan.add');
Route::post('/jurusan/save', [jurusanController::class, 'save'])->name('jurusan.save');
Route::get('/jurusan/edit/{id}', [jurusanController::class, 'edit'])->name('jurusan.edit');
Route::put('/jurusan/update/{id}', [jurusanController::class, 'update'])->name('jurusan.update');
Route::delete('/jurusan/delete/{id}', [jurusanController::class, 'delete'])->name('jurusan.delete');
Route::get('/jurusan/import', [jurusanController::class, 'import'])->name('jurusan.import');
Route::post('/jurusan/import', [jurusanController::class, 'importStore'])->name('jurusan.import.store');

// USER
Route::get('/user', [userController::class, 'index'])->name('user');
Route::get('/user/add', [userController::class, 'add'])->name('user.add');
Route::post('/user/save', [userController::class, 'save'])->name('user.save');
Route::get('/user/edit/{id}', [userController::class, 'edit'])->name('user.edit');
Route::put('/user/update/{id}', [userController::class, 'update'])->name('user.update');
Route::delete('/user/delete/{id}', [userController::class, 'delete'])->name('user.delete');
Route::get('/user/import', [userController::class, 'import'])->name('user.import');
Route::post('/user/import', [userController::class, 'importStore'])->name('user.import.store');

// ==== ADMIN & GURU ===== ##
// TUGAS
Route::get('/id/guru/tugas', [tugasController::class, 'index'])->name('tugas');
Route::get('/id/guru/tugas/add', [tugasController::class, 'add'])->name('tugas.add');
Route::post('/id/guru/tugas/save', [tugasController::class, 'save'])->name('tugas.save');
Route::get('/id/guru/tugas/edit/{id}', [tugasController::class, 'edit'])->name('tugas.edit');
Route::put('/id/guru/tugas/update/{id}', [tugasController::class, 'update'])->name('tugas.update');
Route::delete('/id/guru/tugas/delete/{id}', [tugasController::class, 'delete'])->name('tugas.delete');
Route::get('/id/guru/tugas/{id}/file', [tugasController::class, 'downloadFile'])->name('tugas.file');

// ==== SISWA ===== ##
// DASHBOARD
Route::get('/id/siswa/dashboard', [userSiswaController::class, 'dashboard'])->name('userSiswa.dashboard');

// ABSENSI
Route::get('/id/siswa/absensi', [absensiController::class, 'index'])->name('absensi');
Route::get('/id/siswa/absensi/add', [absensiController::class, 'addAbsensi'])->name('absensi.add');
Route::post('/id/siswa/absensi/save', [absensiController::class, 'saveAbsensi'])->name('absensi.save');
Route::get('/id/siswa/absensi/edit/{id}', [absensiController::class, 'editAbsensi'])->name('absensi.edit');
Route::put('/id/siswa/absensi/update/{id}', [absensiController::class, 'updateAbsensi'])->name('absensi.update');
Route::delete('/id/siswa/absensi/delete/{id}', [absensiController::class, 'deleteAbsensi'])->name('absensi.delete');

// PENDAFTARAN
Route::get('/id/siswa/pendaftaran', [userSiswaController::class, 'pendaftaran'])->name('userSiswa.pendaftaran');
Route::post('/id/siswa/pendaftaran', [userSiswaController::class, 'attemptPendaftaran'])->name('userSiswa.pendaftaran.attempt');
Route::get('/id/siswa/pendaftaran/edit', [userSiswaController::class, 'editPendaftaran'])->name('userSiswa.pendaftaran.edit');
Route::put('/id/siswa/pendaftaran', [userSiswaController::class, 'updatePendaftaran'])->name('userSiswa.pendaftaran.update');

// TUGAS
Route::get('/id/siswa/tugas', [userSiswaController::class, 'tugas'])->name('userSiswa.tugas');
Route::get('/id/siswa/tugas/{id}/kerjakan', [userSiswaController::class, 'tugasKerjakan'])->name('userSiswa.tugas.kerjakan');
Route::post('/id/siswa/tugas/{id}/kerjakan', [userSiswaController::class, 'attemptTugasKerjakan'])->name('userSiswa.tugas.kerjakan.attempt');
Route::post('/id/siswa/tugas/{id}/batalkan', [userSiswaController::class, 'cancelTugasKerjakan'])->name('userSiswa.tugas.kerjakan.cancel');
