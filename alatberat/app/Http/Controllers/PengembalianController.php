<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Models\Anggota;

class PengembalianController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Admin dan Kepala PT bisa melihat semua
        if (in_array($user->role, ['A', 'K'])) {
            $pengembalian = Pengembalian::with(['peminjaman.alat', 'peminjaman.anggota'])
            ->join('peminjamen', 'pengembalians.peminjaman_id', '=', 'peminjamen.id')
            ->join('anggotas', 'peminjamen.anggota_id', '=', 'anggotas.id')
            ->orderBy('anggotas.nama_pt', 'asc')
            ->orderBy('peminjamen.tanggal_pinjam', 'asc')
            ->select('pengembalians.*')
            ->get();
        } else {
            // User hanya bisa melihat miliknya
            $anggota = Anggota::where('user_id', $user->id)->first();

            $pengembalian = Pengembalian::with('peminjaman.alat')
                ->whereHas('peminjaman', function ($query) use ($anggota) {
                    $query->where('anggota_id', $anggota->id);
                })->get();
        }

        return view('pengembalian.index')->with('pengembalian', $pengembalian);
    }

    public function create()
    {
        $anggota = Anggota::where('user_id', Auth::id())->first();

        $peminjaman = Peminjaman::where('status_peminjaman', 'Disetujui')
            ->where('anggota_id', $anggota->id)
            ->get();

        return view('pengembalian.create')->with('peminjaman', $peminjaman);
    }

    public function store(Request $request)
    {
        $val = $request->validate([
            'peminjaman_id' => 'required|exists:peminjamen,id',
            'tanggal_kembali' => 'required|date',
            'kondisi_alat' => 'required|in:baik,rusak,hilang',
            'catatan' => 'nullable|string|max:255',
        ]);

        $peminjaman = Peminjaman::findOrFail($val['peminjaman_id']);
        $anggota = Anggota::where('user_id', Auth::id())->first();

        if ($peminjaman->anggota_id !== $anggota->id) {
            abort(403, 'Anda tidak berhak melakukan pengembalian ini.');
        }

        if ($peminjaman->status_peminjaman !== 'Disetujui') {
            return back()->withErrors(['peminjaman_id' => 'Peminjaman tidak valid.'])->withInput();
        }

        if ($val['tanggal_kembali'] < $peminjaman->tanggal_pinjam) {
            return back()->withErrors(['tanggal_kembali' => 'Tanggal pengembalian tidak boleh sebelum tanggal pinjam.'])->withInput();
        }

        if ($val['tanggal_kembali'] > $peminjaman->tanggal_kembali) {
            return back()->withErrors(['tanggal_kembali' => 'Tanggal pengembalian melebihi batas waktu.'])->withInput();
        }

        $val['status_pengembalian'] = 'pending';
        Pengembalian::create($val);

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil ditambahkan.');
    }

    public function acc(Request $request, $id)
    {
        $user = Auth::user();

        // Hanya Admin atau Kepala PT yang boleh acc
        if (!in_array($user->role, ['A', 'K'])) {
            abort(403, 'Anda tidak memiliki hak untuk menyetujui pengembalian.');
        }

        $pengembalian = Pengembalian::findOrFail($id);
        $status = $request->input('status_pengembalian');

        if (!in_array($status, ['Diterima', 'ditolak'])) {
            return back()->withErrors(['status_pengembalian' => 'Status tidak valid.']);
        }

        $pengembalian->status_pengembalian = $status;
        $pengembalian->save();

        $peminjaman = $pengembalian->peminjaman;
        $alat = $peminjaman->alat;

        if ($status === 'Diterima') {
            $peminjaman->status_peminjaman = 'dikembalikan';
            if ($alat) {
                $alat->status = 'tersedia';
                $alat->save();
            }
        } elseif ($status === 'ditolak') {
            $peminjaman->status_peminjaman = 'Disetujui';
            if ($alat) {
                $alat->status = 'dipinjam';
                $alat->save();
            }
        }

        $peminjaman->save();

        return redirect()->route('pengembalian.index')->with('success', 'Status pengembalian berhasil diperbarui.');
    }

    public function edit(Pengembalian $pengembalian)
    {
        $anggota = Anggota::where('user_id', Auth::id())->first();
        $peminjaman = Peminjaman::where('status_peminjaman', 'Disetujui')
            ->where('anggota_id', $anggota->id)
            ->get();

        return view('pengembalian.edit', compact('pengembalian', 'peminjaman'));
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        $val = $request->validate([
            'peminjaman_id' => 'required|exists:peminjamen,id',
            'tanggal_kembali' => 'required|date',
            'kondisi_alat' => 'required|in:baik,rusak,hilang',
            'catatan' => 'nullable|string|max:255',
        ]);

        $peminjaman = Peminjaman::findOrFail($val['peminjaman_id']);
        $anggota = Anggota::where('user_id', Auth::id())->first();

        if ($peminjaman->anggota_id !== $anggota->id) {
            abort(403, 'Anda tidak berhak memperbarui data ini.');
        }

        if ($val['tanggal_kembali'] < $peminjaman->tanggal_pinjam) {
            return back()->withErrors(['tanggal_kembali' => 'Tanggal pengembalian tidak boleh sebelum tanggal pinjam.'])->withInput();
        }

        if ($val['tanggal_kembali'] > $peminjaman->tanggal_kembali) {
            return back()->withErrors(['tanggal_kembali' => 'Tanggal pengembalian melebihi batas waktu.'])->withInput();
        }

        $val['status_pengembalian'] = 'pending';
        $pengembalian->update($val);

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil diperbarui.');
    }

    public function show(Pengembalian $pengembalian)
    {
        //
    }

    public function destroy(Pengembalian $pengembalian)
    {
        //
    }
}
