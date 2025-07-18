<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AlatController extends Controller
{
    // Menampilkan daftar alat untuk user (tampilan kartu)
    public function index()
    {
        $alat = Alat::all();
        $user = auth()->user();
        $isAdmin = $user && $user->role === 'A';

        return view('alat.index')->with([
            'alat' => $alat,
            'isAdmin' => $isAdmin,
        ]);
    }

    // Menampilkan form untuk menambah alat baru
    public function create()
    {
        return view('alat.create');
    }

    // Menyimpan data alat baru ke database
    public function store(Request $request)
    {
        $val = $request->validate([
            'kode_alat' => 'required|string|max:10|unique:alats,kode_alat',
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'tahun_pembelian' => 'required|date_format:Y',
            'jumlah' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Str::uuid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('fotoalat'), $filename);
            $val['foto'] = $filename;
        }

        Alat::create($val);
        return redirect()->route('alat.index')->with('success', $val['kode_alat'] . ' berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit data alat
    public function edit(Alat $alat)
    {
        return view('alat.edit')->with('alat', $alat);
    }

    // Memperbarui data alat yang sudah ada di database
    public function update(Request $request, Alat $alat)
    {
        $val = $request->validate([
            'kode_alat' => 'required|string|max:10|unique:alats,kode_alat,' . $alat->id,
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'tahun_pembelian' => 'required|date_format:Y',
            'jumlah' => 'required|integer|min:1',
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
}
