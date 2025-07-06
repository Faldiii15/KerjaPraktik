<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pemeliharaan;
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
        $peminjaman = Peminjaman::with('alat')->get();
        return view('laporan.peminjaman', compact('peminjaman'));
    }

    public function exportPeminjaman()
    {
        $peminjaman = Peminjaman::with('alat')->get();

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

    public function laporanPengembalian()
    {
        $pengembalian = Pengembalian::with(['peminjaman.alat'])->get();
        return view('laporan.pengembalian', compact('pengembalian'));
    }

    public function exportPengembalian()
    {
        $pengembalian = Pengembalian::with(['peminjaman.alat'])->get();

        Laporan::create([
            'id' => Str::uuid(),
            'judul' => 'Laporan Pengembalian Alat',
            'tipe' => 'pengembalian',
            'tanggal_dibuat' => now(),
            'keterangan' => 'Export laporan pengembalian ke PDF',
        ]);

        $pdf = PDF::loadView('laporan.pengembalian_pdf', compact('pengembalian'));
        return $pdf->download('laporan-pengembalian-alat.pdf');
    }

    public function laporanPemeliharaan()
    {
        $data = Pemeliharaan::with('alat')->get();
        return view('laporan.pemeliharaan', compact('data'));
    }

    public function laporanPemeliharaanPDF()
    {
        $data = Pemeliharaan::with('alat')->get();
        $pdf = Pdf::loadView('laporan.pemeliharaan_pdf', compact('data'));
        return $pdf->download('laporan-pemeliharaan.pdf');
    }

}
