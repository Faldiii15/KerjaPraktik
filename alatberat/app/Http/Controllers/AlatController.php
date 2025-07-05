<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = Str::uuid() . '_' . $file->getClientOriginalName();
        $file->move(public_path('fotoalat'), $filename);
        $val['foto'] = $filename;
    }

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
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($alat->foto && file_exists(public_path('fotoalat/' . $alat->foto))) {
                unlink(public_path('fotoalat/' . $alat->foto));
            }

            $file = $request->file('foto');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('fotoalat'), $filename);
            $val['foto'] = $filename;
        }
        

        $alat->update($val);
        return redirect()->route('alat.index')->with('success', $val['kode_alat'] . ' berhasil diperbarui.');
    }
    public function destroy(Alat $alat)
    {
        //
    }
}
