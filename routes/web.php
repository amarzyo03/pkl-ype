<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/user', [userController::class, 'index'])->name('user');
Route::get('/user/add', [userController::class, 'add'])->name('user.add');
Route::post('/user/save', [userController::class, 'save'])->name('user.save');
Route::get('/user/edit/{id}', [userController::class, 'edit'])->name('user.edit');
Route::put('/user/update/{id}', [userController::class, 'update'])->name('user.update');
Route::delete('/user/delete/{id}', [userController::class, 'delete'])->name('user.delete');
Route::get('/user/import', [userController::class, 'import'])->name('user.import');
Route::post('/user/import', [userController::class, 'importStore'])->name('user.import.store');

Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
