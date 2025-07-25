    <?php

    use App\Http\Controllers\AlatController;
    use App\Http\Controllers\UnitAlatController;
    use App\Http\Controllers\AnggotaController;
    use App\Http\Controllers\PemeliharaanController;
    use App\Http\Controllers\PeminjamanController;
    use App\Http\Controllers\PengembalianController;
    use App\Http\Controllers\ProfileController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\LaporanController;

    use App\Http\Controllers\DashboardController;

    Route::middleware(['auth', 'role:A'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::get('/', function () {
        return view('welcome');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::middleware(['auth', 'role:A,U,K'])->group(function () {
        Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');
        
    });

    Route::middleware(['auth', 'role:A'])->group(function () {
        Route::get("/alat/create", [AlatController::class, 'create'])->name('alat.create');
        Route::post("/alat/store", [AlatController::class, 'store'])->name('alat.store');
        Route::get("/alat/{alat}/edit", [AlatController::class, 'edit'])->name('alat.edit');
        Route::put("/alat/{alat}/update", [AlatController::class, 'update'])->name('alat.update');
    });

    // Hanya admin, user, dan kepala PT bisa lihat daftar unit
    Route::middleware(['auth', 'role:A,U,K'])->group(function () {
        Route::get('/alat/{alat}/unit', [UnitAlatController::class, 'index'])->name('unit.index');
    });

    // Hanya admin yang bisa menambahkan unit baru
    Route::middleware(['auth', 'role:A'])->group(function () {
        Route::get('/alat/{alat}/unit/create', [UnitAlatController::class, 'create'])->name('unit.create');
        Route::post('/alat/{alat}/unit', [UnitAlatController::class, 'store'])->name('unit.store');
    });


    Route::middleware(['auth', 'role:A'])->group(function () {
        Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    });

    Route::middleware(['auth', 'role:A,U,K'])->group(function () {
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        
    });

    Route::middleware(['auth', 'role:A,U'])->group(function () {
        Route::get("/peminjaman/create", [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post("/peminjaman/store", [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get("/peminjaman/{peminjaman}/edit", [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
        Route::put("/peminjaman/{peminjaman}/update", [PeminjamanController::class, 'update'])->name('peminjaman.update');          
    });
    Route::middleware(['auth', 'role:A,K'])->group(function () {
        Route::put('peminjaman/{peminjaman}/acc', [PeminjamanController::class, 'acc'])->name('peminjaman.acc');
        Route::put('/peminjaman/{id}/alasan', [PeminjamanController::class, 'updateAlasan'])->name('peminjaman.alasan.update');
    });

    Route::middleware(['auth', 'role:A,U'])->group(function () {
    Route::get('/peminjaman/get-units/{alat_id}', [PeminjamanController::class, 'getUnits'])->name('peminjaman.getUnits');
    });



    Route::middleware(['auth', 'role:A,U'])->group(function () {
        Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');

    });
    Route::middleware(['auth', 'role:A,U'])->group(function () {
        Route::get("/pengembalian/create", [PengembalianController::class, 'create'])->name('pengembalian.create');
        Route::post("/pengembalian/store", [PengembalianController::class, 'store'])->name('pengembalian.store');
        Route::put('pengembalian/{pengembalian}/acc', [PengembalianController::class, 'acc'])->name('pengembalian.acc');
    });


    Route::middleware(['auth', 'role:A'])->group(function () {
        Route::get('/pemeliharaan', [PemeliharaanController::class, 'index'])->name('pemeliharaan.index');
    });
    Route::middleware(['auth', 'role:A'])->group(function () {
        Route::get("/pemeliharaan/create", [PemeliharaanController::class, 'create'])->name('pemeliharaan.create');
        Route::post("/pemeliharaan/store", [PemeliharaanController::class, 'store'])->name('pemeliharaan.store');
        Route::put('/pemeliharaan/{id}/selesai', [PemeliharaanController::class, 'selesai'])->name('pemeliharaan.selesai');
        Route::get("/pemeliharaan/{pemeliharaan}/edit", [PemeliharaanController::class, 'edit'])->name('pemeliharaan.edit');
        Route::put("/pemeliharaan/{pemeliharaan}/update", [PemeliharaanController::class, 'update'])->name('pemeliharaan.update');
    });

    Route::middleware(['auth', 'role:A'])->group(function () {
    Route::get('/pemeliharaan/units/{alat}', [PemeliharaanController::class, 'getUnits'])->name('pemeliharaan.get-units');
    });



    Route::middleware(['auth', 'role:A,K'])->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });
    Route::middleware(['auth', 'role:A,K'])->group(function () {
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
