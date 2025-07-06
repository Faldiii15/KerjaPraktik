<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\PemeliharaanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ProfileController;
usE App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Alat;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('alat', AlatController::class);
Route::resource('peminjaman', PeminjamanController::class);
Route::put('peminjaman/{id}/acc', [PeminjamanController::class, 'acc'])->name('peminjaman.acc');
Route::resource('pengembalian', PengembalianController::class);
Route::put('pengembalian/{id}/acc', [PengembalianController::class, 'acc'])->name('pengembalian.acc');
Route::resource('pemeliharaan', PemeliharaanController::class);

require __DIR__.'/auth.php';
