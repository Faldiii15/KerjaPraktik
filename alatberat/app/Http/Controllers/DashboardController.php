<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pemeliharaan;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahAlat = Alat::count();
        $jumlahPeminjaman = Peminjaman::count();
        $jumlahPengembalian = Pengembalian::count();
        $jumlahPemeliharaan = Pemeliharaan::count();

        return view('dashboard', compact(
            'jumlahAlat',
            'jumlahPeminjaman',
            'jumlahPengembalian',
            'jumlahPemeliharaan'
        ));
    }
}
