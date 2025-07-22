<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->role, ['A', 'K'])) {
            $pengembalian = Pengembalian::with(['peminjaman.alat', 'peminjaman.anggota', 'peminjaman.units'])
                ->join('peminjamen', 'pengembalians.peminjaman_id', '=', 'peminjamen.id')
                ->leftJoin('anggotas', 'peminjamen.anggota_id', '=', 'anggotas.id') // GUNAKAN leftJoin!
                ->orderBy('peminjamen.tanggal_pinjam')
                ->select('pengembalians.*')
                ->get();
        } else {
            $anggota = Anggota::where('user_id', $user->id)->firstOrFail();
            $pengembalian = Pengembalian::with(['peminjaman.alat', 'peminjaman.units'])
                ->whereHas('peminjaman', fn($q) => $q->where('anggota_id', $anggota->id))
                ->get();
        }

        return view('pengembalian.index', compact('pengembalian'));
    }


    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'U') {
            $anggota = Anggota::where('user_id', $user->id)->firstOrFail();
            $peminjaman = Peminjaman::with(['alat', 'units'])
                ->where('status_peminjaman', 'Disetujui')
                ->where('anggota_id', $anggota->id)
                ->get();
        } else {
            $peminjaman = Peminjaman::with(['alat', 'units'])
                ->where('status_peminjaman', 'Disetujui')
                ->get();
        }

        return view('pengembalian.create', compact('peminjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamen,id',
            'tanggal_kembali' => 'required|date',
            'kondisi_alat' => 'required|in:baik,rusak,hilang',
            'catatan' => 'nullable|string|max:255',
        ]);

        $peminjaman = Peminjaman::with('units')->findOrFail($request->peminjaman_id);
        $user = Auth::user();

        // Cek role user
        if ($user->role === 'U') {
            $anggota = Anggota::where('user_id', $user->id)->firstOrFail();
            if ($peminjaman->anggota_id !== $anggota->id) {
                abort(403, 'Tidak boleh mengembalikan milik orang lain.');
            }
        }

        // Validasi tanggal pengembalian
        if ($request->tanggal_kembali < $peminjaman->tanggal_pinjam) {
            return back()->withErrors(['tanggal_kembali' => 'Tanggal pengembalian tidak boleh sebelum tanggal pinjam.'])->withInput();
        }

        if ($request->tanggal_kembali > $peminjaman->tanggal_kembali) {
            return back()->withErrors(['tanggal_kembali' => 'Pengembalian melebihi batas waktu.'])->withInput();
        }

        // Simpan pengembalian
        Pengembalian::create([
            'peminjaman_id' => $request->peminjaman_id,
            'tanggal_kembali' => $request->tanggal_kembali,
            'kondisi_alat' => $request->kondisi_alat,
            'catatan' => $request->catatan,
            'status_pengembalian' => 'pending',
        ]);

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil ditambahkan.');
    }


    public function acc(Request $request, $id)
    {
        $request->validate([
            'status_pengembalian' => 'required|in:Diterima,ditolak'
        ]);

        if (!in_array(Auth::user()->role, ['A', 'K'])) {
            abort(403);
        }

        $pengembalian = Pengembalian::with('peminjaman.units')->findOrFail($id);
        $status = $request->status_pengembalian;

        if ($pengembalian->status_pengembalian === 'Diterima') {
            return back()->with('warning', 'Sudah dikonfirmasi sebelumnya.');
        }

        $pengembalian->status_pengembalian = $status;
        $pengembalian->save();

        $peminjaman = $pengembalian->peminjaman;

        if ($status === 'Diterima') {
            $peminjaman->status_peminjaman = 'selesai';
            foreach ($peminjaman->units as $unit) {
                $unit->status = 'tersedia';
                $unit->save();
            }
        } else {
            $peminjaman->status_peminjaman = 'Disetujui';
            foreach ($peminjaman->units as $unit) {
                $unit->status = 'dipinjam';
                $unit->save();
            }
        }

        $peminjaman->save();

        return redirect()->route('pengembalian.index')->with('success', 'Status pengembalian berhasil diperbarui.');
    }
}
