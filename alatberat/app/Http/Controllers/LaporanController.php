<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    // Tampilkan halaman laporan alat berat
    public function laporanAlat()
    {
        $alat = Alat::all();
        return view('laporan.alat', compact('alat'));
    }

    // Export PDF laporan alat berat + simpan ke tabel laporan
    public function exportAlat()
    {
        $alat = Alat::all();
         $user = Auth::user();

        // Simpan log laporan ke database
        Laporan::create([
            'id' => Str::uuid(),
            'judul' => 'Laporan Alat Berat',
            'tipe' => 'alat',
            'tanggal_dibuat' => now(),
            'keterangan' => 'Export laporan alat berat ke PDF',
        ]);

        // Buat PDF dan kembalikan sebagai download
        $pdf = PDF::loadView('laporan.alat_pdf', compact('alat', 'user'));
        return $pdf->download('laporan-alat-berat.pdf');
    }


    public function laporanPeminjaman()
    {
        $peminjaman = Peminjaman::with(['alat', 'user'])->get();
        return view('laporan.peminjaman', compact('peminjaman'));
    }

    public function exportPeminjaman()
    {
        $peminjaman = Peminjaman::with(['alat', 'user'])->get();

        // Simpan ke tabel laporan
        Laporan::create([
            'id' => Str::uuid(),
            'judul' => 'Laporan Peminjaman Alat',
            'tipe' => 'peminjaman',
            'tanggal_dibuat' => now(),
            'keterangan' => 'Export laporan peminjaman ke PDF',
        ]);

        $pdf = PDF::loadView('laporan.peminjaman_pdf', compact('peminjaman'));
        return $pdf->download('laporan-peminjaman-alat.pdf');
    }

}
