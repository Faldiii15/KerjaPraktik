<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Pemeliharaan;
use Illuminate\Http\Request;

class PemeliharaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemeliharaan = Pemeliharaan::with('alat')->get();
        return view('pemeliharaan.index')->with('pemeliharaan', $pemeliharaan);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alat = Alat::where('status', 'tersedia')->get();
        return view('pemeliharaan.create')->with('alat', $alat);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    
    {
        $val = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Proses,Selesai',
            'teknisi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $alat = Alat::find($val['alat_id']);

        Pemeliharaan:: create($val);


       if ($val['status'] === 'Proses') {
            $alat->status = 'diperbaiki';
        } elseif ($val['status'] === 'Selesai') {
            $alat->status = 'tersedia';
            
        }
        $alat->save();

        return redirect()->route('pemeliharaan.index')->with('success', 'Pemeliharaan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemeliharaan $pemeliharaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemeliharaan $pemeliharaan)
    {
       $alat = Alat::where('status', 'tersedia')
        ->orWhere('id', $pemeliharaan->alat_id) // tambahkan alat yg sedang dipinjam user ini
        ->get();
        return view('pemeliharaan.edit')->with('pemeliharaan', $pemeliharaan)->with('alat', $alat);
    
        return view('pemeliharaan.edit')->with('pemeliharaan', $pemeliharaan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemeliharaan $pemeliharaan)
    {
        $val = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Proses,Selesai',
            'teknisi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $alat = Alat::find($val['alat_id']);

        $pemeliharaan->update($val);

        if ($val['status'] === 'Proses') {
            $alat->status = 'diperbaiki';
        } elseif ($val['status'] === 'Selesai') {
            $alat->status = 'tersedia';
        }
        $alat->save();

        return redirect()->route('pemeliharaan.index')->with('success', 'Pemeliharaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemeliharaan $pemeliharaan)
    {
        //
    }
}
