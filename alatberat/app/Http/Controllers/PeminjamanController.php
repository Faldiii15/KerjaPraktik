<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alat = Alat::all();
        $peminjam = \App\Models\User::all();
        $peminjaman = \App\Models\Peminjaman::with(['user', 'alat'])->get();

        return view('peminjaman.index', compact('alat', 'peminjam', 'peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $alat = Alat::all();
    $peminjam = \App\Models\User::all();

    return view('peminjaman.create', compact('alat', 'peminjam'));
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_peminjaman' => 'required|string|max:255|unique:peminjamen,id_peminjaman',
            'nama_peminjam' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'keperluan' => 'required|string|max:255',
            
        ]);

        Peminjaman::create($validatedData);
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }
}
