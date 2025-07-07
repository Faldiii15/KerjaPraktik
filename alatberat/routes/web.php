<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PemeliharaanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\ProfileController;
usE App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Alat;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;
use App\Http\Controllers\LaporanController;

use App\Http\Controllers\DashboardController;
use App\Models\Anggota;
use App\Models\Pemeliharaan;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

Route::get('/dashboard', [DashboardController::class, 
    'index'])->middleware('auth', 'verified')->name('dashboard');



Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:A,U,P'])->group(function () {
    Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');
    
});

Route::middleware(['auth', 'role:A'])->group(function () {
    Route::get("/alat/create", [AlatController::class, 'create'])->name('alat.create');
    Route::post("/alat/store", [AlatController::class, 'store'])->name('alat.store');
    Route::get("/alat/{id}/edit", [AlatController::class, 'edit'])->name('alat.edit');
    Route::put("/alat/{id}/update", [AlatController::class, 'update'])->name('alat.update');
});

Route::middleware(['auth', 'role:A,U'])->group(function () {
    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    
});

Route::middleware(['auth', 'role:U'])->group(function () {
    Route::get("/anggota/create", [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post("/anggota/store", [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{anggota}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{anggota}/update', [AnggotaController::class, 'update'])->name('anggota.update');
});



Route::middleware(['auth', 'role:A,U'])->group(function () {
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    
});

Route::middleware(['auth', 'role:A,U'])->group(function () {
    Route::get("/peminjaman/create", [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post("/peminjaman/store", [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::put('peminjaman/{peminjaman}/acc', [PeminjamanController::class, 'acc'])->name('peminjaman.acc');
    Route::get("/peminjaman/{peminjaman}/edit", [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put("/peminjaman/{peminjaman}/update", [PeminjamanController::class, 'update'])->name('peminjaman.update');          
});

Route::middleware(['auth', 'role:A,U'])->group(function () {
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');

});


Route::middleware(['auth', 'role:A,U'])->group(function () {
    Route::get("/pengembalian/create", [PengembalianController::class, 'create'])->name('pengembalian.create');
    Route::post("/pengembalian/store", [PengembalianController::class, 'store'])->name('pengembalian.store');
    Route::put('pengembalian/{pengembalian}/acc', [PengembalianController::class, 'acc'])->name('pengembalian.acc');
    Route::get("/pengembalian/{pengembalian}/edit", [PengembalianController::class, 'edit'])->name('pengembalian.edit');
    Route::put("/pengembalian/{pengembalian}/update", [PengembalianController::class, 'update'])->name('pengembalian.update');
});


Route::middleware(['auth', 'role:A'])->group(function () {
    Route::get('/pemeliharaan', [PemeliharaanController::class, 'index'])->name('pemeliharaan.index');
});
Route::middleware(['auth', 'role:A'])->group(function () {
    Route::get("/pemeliharaan/create", [PemeliharaanController::class, 'create'])->name('pemeliharaan.create');
    Route::post("/pemeliharaan/store", [PemeliharaanController::class, 'store'])->name('pemeliharaan.store');
    Route::get("/pemeliharaan/{pemeliharaan}/edit", [PemeliharaanController::class, 'edit'])->name('pemeliharaan.edit');
    Route::put("/pemeliharaan/{pemeliharaan}/update", [PemeliharaanController::class, 'update'])->name('pemeliharaan.update');
});


Route::middleware(['auth', 'role:A,P'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});
Route::middleware(['auth', 'role:A,'])->group(function () {
    Route::get('laporan/alat', [LaporanController::class, 'laporanAlat'])->name('laporan.alat');
    Route::get('/laporan/alat/pdf', [LaporanController::class, 'exportAlat'])->name('laporan.alat.pdf');
    Route::get('/laporan/peminjaman', [LaporanController::class, 'laporanPeminjaman'])->name('laporan.peminjaman');
    Route::get('/laporan/peminjaman/pdf', [LaporanController::class, 'exportPeminjaman'])->name('laporan.peminjaman.pdf');
    Route::get('/laporan/pengembalian', [LaporanController::class, 'laporanPengembalian'])->name('laporan.pengembalian');
    Route::get('/laporan/pengembalian/pdf', [LaporanController::class, 'exportPengembalian'])->name('laporan.pengembalian.pdf');
    Route::get('/laporan/pemeliharaan', [LaporanController::class, 'laporanPemeliharaan'])->name('laporan.pemeliharaan');
    Route::get('/laporan/pemeliharaan/pdf', [LaporanController::class, 'laporanPemeliharaanPDF'])->name('laporan.pemeliharaan.pdf');
});

require __DIR__.'/auth.php';
