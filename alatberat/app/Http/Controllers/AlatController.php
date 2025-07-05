<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alat = Alat::all();
        return view('alat.index')->with('alat', $alat);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('alat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $val = $request->validate([
            'kode_alat' => 'required|string|max:10',
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'tahun_pembelian' => 'required|date_format:Y',
            'status' => 'required|in:tersedia,rusak,dipinjam',
        ]);

        Alat::create($val);
        return redirect()->route('alat.index')->with('success', $val['kode_alat'] . 'Alat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alat $alat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alat $alat)
    {
        return view('alat.edit')->with('alat', $alat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alat $alat)
    {
        $val = $request->validate([
            'kode_alat' => 'required|string|max:10',
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'tahun_pembelian' => 'required|date_format:Y',
            'status' => 'required|in:tersedia,rusak,dipinjam',
        ]);

        $alat->update($val);
        return redirect()->route('alat.index')->with('success', $val['kode_alat'] . ' berhasil diperbarui.');
    }
    public function destroy(Alat $alat)
    {
        //
    }
}
