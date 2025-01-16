<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PerpusController;
use App\Http\Controllers\PinjamController;


Route::get('/dashboard', [UserController::class, 'dashboard']);
//login dan user
Route::get('/', [UserController::class, 'login']);
Route::post('/login', [UserController::class, 'loginpost']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{id}/delete', [UserController::class, 'destroy'])->name('user.destroy');

//halaman awal
Route::get('/perpus', [PerpusController::class, 'index'])->name('perpus.index');
Route::post('/perpus/{id}/pinjam', [PerpusController::class, 'pinjamBuku'])->name('perpus.pinjam');
Route::post('/buku/kembalikan/{id}', [PerpusController::class, 'kembalikanBuku'])->name('perpus.kembalikan');




//buku
Route::get('/buku', [BukuController::class, 'index']);
Route::get('/buku/tambah', [BukuController::class, 'create']);
Route::post('/buku/tambah', [BukuController::class, 'store']);
Route::get('/buku/edit/{id}', [BukuController::class, 'edit']);
Route::post('/buku/update/{id}', [BukuController::class, 'update']);
Route::get('/buku/hapus/{id}', [BukuController::class, 'destroy']);

//kategori
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
Route::get('/kategori/{id}/delete', [KategoriController::class, 'destroy'])->name('kategori.destroy');

//pinjam
Route::get('/pinjam', [PinjamController::class, 'index']);
Route::get('/pinjam/tambah', [PinjamController::class, 'create']);
Route::post('/pinjam/tambah', [PinjamController::class, 'store']);
Route::get('/pinjam/edit/{id}', [PinjamController::class, 'edit']);
Route::post('/pinjam/update/{id}', [PinjamController::class, 'up    date']);
Route::get('/pinjam/hapus/{id}', [PinjamController::class, 'destroy']);
Route::post('/pinjam/update-status/{id}', [PinjamController::class, 'updateStatus']);

