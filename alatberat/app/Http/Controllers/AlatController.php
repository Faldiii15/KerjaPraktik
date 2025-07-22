<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlatController extends Controller
{
    // Menampilkan daftar jenis alat
    public function index()
    {
        $alat = Alat::withCount('tersediaUnits')->get();
        $user = auth()->user();
        $isAdmin = $user && $user->role === 'A';

        return view('alat.index', compact('alat', 'isAdmin'));
    }

    // Form tambah alat
    public function create()
    {
        return view('alat.create');
    }

    // Simpan alat baru
    public function store(Request $request)
    {
        $val = $request->validate([
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
        return redirect()->route('alat.index')->with('success', 'Data alat berhasil ditambahkan.');
    }

    // Form edit alat
    public function edit(Alat $alat)
    {
        return view('alat.edit', compact('alat'));
    }

    // Update data alat
    public function update(Request $request, Alat $alat)
    {
        $val = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'tahun_pembelian' => 'required|date_format:Y',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($alat->foto && file_exists(public_path('fotoalat/' . $alat->foto))) {
                unlink(public_path('fotoalat/' . $alat->foto));
            }

            $file = $request->file('foto');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('fotoalat'), $filename);
            $val['foto'] = $filename;
        }

        $alat->update($val);
        return redirect()->route('alat.index')->with('success', 'Data alat berhasil diperbarui.');
    }
}
