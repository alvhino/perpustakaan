<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
Route::get('/', function () {
    return view('template.index');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
});


Route::get('/login', [UserController::class, 'login']);


Route::get('/buku', [BukuController::class, 'index']);
Route::get('/buku/tambah', [BukuController::class, 'create']);
Route::post('/buku/tambah', [BukuController::class, 'store']);
Route::get('/buku/edit/{id}', [BukuController::class, 'edit']);
Route::post('/buku/update/{id}', [BukuController::class, 'update']);
Route::get('/buku/hapus/{id}', [BukuController::class, 'destroy']);


Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/kategori/tambah', [KategoriController::class, 'create']);
Route::post('/kategori/tambah', [KategoriController::class, 'store']);
Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit']);
Route::post('/kategori/update/{id}', [KategoriController::class, 'update']);
Route::get('/kategori/hapus/{id}', [KategoriController::class, 'destroy']);