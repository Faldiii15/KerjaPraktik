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
        $pengembalian = Pengembalian::all();
        return view('pengembalian.index')->with('pengembalian', $pengembalian);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $peminjaman = Peminjaman::where('status_peminjaman', 'dipinjam')->get();
        return view('pengembalian.create')->with('peminjaman', $peminjaman);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $val = $request->validate([
            'peminjaman_id' => 'required|exists:peminjamen,id',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'kondisi_alat' => 'required|in:baik,rusak,hilang', // Kondisi alat saat dikembalikan
            'catatan' => 'nullable|string|max:255',
        ]);

        $val['status_pengembalian'] = 'pending';

        // Pastikan peminjaman yang dipilih masih dalam status 'dipinjam'
        $peminjaman = Peminjaman::find($val['peminjaman_id']);
        if ($peminjaman->status_peminjaman !== 'dipinjam') {
            return back()->withErrors(['peminjaman_id' => 'Peminjaman tidak valid.'])->withInput();
        }

        Pengembalian::create($val);

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil ditambahkan.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengembalian $pengembalian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengembalian $pengembalian)
    {
        //
    }
}
