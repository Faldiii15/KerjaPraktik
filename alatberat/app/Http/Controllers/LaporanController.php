<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pemeliharaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function laporanAlat()
    {
        $alat = Alat::with('units')->get(); // Include unit details
        return view('laporan.alat', compact('alat'));
    }

    public function exportAlat()
    {
        $alat = Alat::with('units')->get(); // Include unit details
        $user = Auth::user();

        Laporan::create([
            'judul' => 'Laporan Alat Berat',
            'tipe' => 'alat',
            'tanggal_dibuat' => now(),
            'keterangan' => 'Export laporan alat berat ke PDF',
        ]);

        $pdf = PDF::loadView('laporan.alat_pdf', compact('alat', 'user'));
        return $pdf->download('laporan-alat-berat.pdf');
        }

    public function laporanPeminjaman()
    {
        $peminjaman = Peminjaman::with(['alat', 'anggota.user'])
            ->join('anggotas', 'peminjamen.anggota_id', '=', 'anggotas.id')
            ->orderBy('anggotas.nama_pt')
            ->orderBy('peminjamen.tanggal_pinjam')
            ->select('peminjamen.*')
            ->get();

        return view('laporan.peminjaman', compact('peminjaman'));
    }

    public function exportPeminjaman()
    {
        $peminjaman = Peminjaman::with(['alat', 'anggota.user'])
            ->join('anggotas', 'peminjamen.anggota_id', '=', 'anggotas.id')
            ->orderBy('anggotas.nama_pt')
            ->orderBy('peminjamen.tanggal_pinjam')
            ->select('peminjamen.*')
            ->get();

        Laporan::create([
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
        $pengembalian = Pengembalian::with(['peminjaman.alat', 'peminjaman.anggota.user'])
            ->join('peminjamen', 'pengembalians.peminjaman_id', '=', 'peminjamen.id')
            ->join('anggotas', 'peminjamen.anggota_id', '=', 'anggotas.id')
            ->orderBy('anggotas.nama_pt')
            ->orderBy('peminjamen.tanggal_pinjam')
            ->select('pengembalians.*')
            ->get();

        return view('laporan.pengembalian', compact('pengembalian'));
    }

    public function exportPengembalian()
    {
        $pengembalian = Pengembalian::with(['peminjaman.alat', 'peminjaman.anggota.user'])
            ->join('peminjamen', 'pengembalians.peminjaman_id', '=', 'peminjamen.id')
            ->join('anggotas', 'peminjamen.anggota_id', '=', 'anggotas.id')
            ->orderBy('anggotas.nama_pt')
            ->orderBy('peminjamen.tanggal_pinjam')
            ->select('pengembalians.*')
            ->get();

        Laporan::create([
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

        Laporan::create([
            'judul' => 'Laporan Pemeliharaan Alat',
            'tipe' => 'pemeliharaan',
            'tanggal_dibuat' => now(),
            'keterangan' => 'Export laporan pemeliharaan ke PDF',
        ]);

        $pdf = Pdf::loadView('laporan.pemeliharaan_pdf', compact('data'));
        return $pdf->download('laporan-pemeliharaan.pdf');
    }
}
