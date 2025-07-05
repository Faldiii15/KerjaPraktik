<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.main');
});

Route::resource('alat', AlatController::class);
Route::resource('peminjaman',PeminjamanController::class);
Route::put('/peminjaman/acc/{id}', [PeminjamanController::class, 'acc'])->name('peminjaman.acc');
Route::resource('pengembalian', PengembalianController::class);