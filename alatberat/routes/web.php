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
use App\Http\Controllers\LaporanController;


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

Route::get('laporan/alat', [LaporanController::class, 'laporanAlat'])->name('laporan.alat');
Route::get('/laporan/alat/pdf', [LaporanController::class, 'exportAlat'])->name('laporan.alat.pdf');
Route::get('/laporan/peminjaman', [LaporanController::class, 'laporanPeminjaman'])->name('laporan.peminjaman');
Route::get('/laporan/peminjaman/pdf', [LaporanController::class, 'exportPeminjaman'])->name('laporan.peminjaman.pdf');
Route::get('/laporan/pengembalian', [LaporanController::class, 'laporanPengembalian'])->name('laporan.pengembalian');
Route::get('/laporan/pengembalian/pdf', [LaporanController::class, 'exportPengembalian'])->name('laporan.pengembalian.pdf');
Route::get('/laporan/pemeliharaan', [LaporanController::class, 'laporanPemeliharaan'])->name('laporan.pemeliharaan');
Route::get('/laporan/pemeliharaan/pdf', [LaporanController::class, 'laporanPemeliharaanPDF'])->name('laporan.pemeliharaan.pdf');






require __DIR__.'/auth.php';
