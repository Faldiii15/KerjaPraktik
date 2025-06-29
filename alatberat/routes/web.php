<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.main');
});

Route::resource('alat', AlatController::class);
Route::resource('peminjaman',PeminjamanController::class);