<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengembalian = Pengembalian::with('peminjaman.alat')->get();
        return view('pengembalian.index')->with('pengembalian', $pengembalian);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $peminjaman = Peminjaman::where('status_peminjaman', 'Disetujui')->get();
        return view('pengembalian.create')->with('peminjaman', $peminjaman);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $val = $request->validate([
            'peminjaman_id' => 'required|exists:peminjamen,id',
            'tanggal_kembali' => 'required|date',
            'kondisi_alat' => 'required|in:baik,rusak,hilang',
            'catatan' => 'nullable|string|max:255',
        ]);

        $peminjaman = Peminjaman::findOrFail($val['peminjaman_id']);

        if ($peminjaman->status_peminjaman !== 'Disetujui') {
            return back()->withErrors(['peminjaman_id' => 'Peminjaman tidak valid.'])->withInput();
        }

        // Validasi tanggal pengembalian tidak boleh terlalu cepat atau terlalu lambat
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
        $pengembalian = Pengembalian::findOrFail($id);
        $status = $request->input('status_pengembalian');

        // Validasi status
        if (!in_array($status, ['Diterima', 'ditolak'])) {
            return back()->withErrors(['status_pengembalian' => 'Status tidak valid.']);
        }

        $pengembalian->status_pengembalian = $status;
        $pengembalian->save();

        // Jika disetujui, ubah status alat menjadi dipinjam
        $peminjaman = $pengembalian->peminjaman;
        $alat = $peminjaman->alat;

        if ($status === 'Diterima') {
            $peminjaman->status_peminjaman = 'dikembalikan';
            
            if ($peminjaman->alat) {
            $peminjaman->alat->status = 'tersedia';
            $peminjaman->alat->save();
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

    /**
     * Display the specified resource.
     */
    public function show(Pengembalian $pengembalian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengembalian $pengembalian)
    {
        $peminjaman = Peminjaman::where('status_peminjaman', 'Disetujui')->get();
        return view('pengembalian.edit', compact('pengembalian', 'peminjaman'));
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengembalian $pengembalian)
    {
        $val = $request->validate([
            'peminjaman_id' => 'required|exists:peminjamen,id',
            'tanggal_kembali' => 'required|date',
            'kondisi_alat' => 'required|in:baik,rusak,hilang',
            'catatan' => 'nullable|string|max:255',
        ]);

        $peminjaman = Peminjaman::findOrFail($val['peminjaman_id']);

        if ($peminjaman->status_peminjaman !== 'Disetujui') {
            return back()->withErrors(['peminjaman_id' => 'Peminjaman tidak valid.'])->withInput();
        }

        // Validasi tanggal pengembalian tidak boleh terlalu cepat atau terlalu lambat
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengembalian $pengembalian)
    {
        //
    }
}
