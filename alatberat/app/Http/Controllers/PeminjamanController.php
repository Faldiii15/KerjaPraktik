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
        $peminjaman = Peminjaman::all();
        return view('peminjaman.index')->with('peminjaman', $peminjaman);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alat = Alat::where('status', 'tersedia')->get();
        return view('peminjaman.create')->with('alat', $alat);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $val = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'nama_peminjam' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'keperluan' => 'required|string|max:255',
        ]);

        // Tambahkan status default
        $val['status_peminjaman'] = 'pending';

        // Pastikan alat tersedia
        $alat = Alat::find($val['alat_id']);
        if ($alat->status !== 'tersedia') {
            return back()->withErrors(['alat_id' => 'Alat tidak tersedia.'])->withInput();
        }

        Peminjaman::create($val);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan dan menunggu persetujuan.');
    }

    public function acc(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $status = $request->input('status_peminjaman');

        // Validasi status
        if (!in_array($status, ['dipinjam', 'ditolak'])) {
            return back()->withErrors(['status_peminjaman' => 'Status tidak valid.']);
        }

        $peminjaman->status_peminjaman = $status;
        $peminjaman->save();

        // Jika disetujui, ubah status alat menjadi dipinjam
        $alat = $peminjaman->alat;

        if ($status === 'dipinjam') {
            $alat->status = 'dipinjam';
        } elseif ($status === 'ditolak') {
            $alat->status = 'tersedia';
        }

        $alat->save();


        return redirect()->route('peminjaman.index')->with('success', 'Status peminjaman berhasil diperbarui.');
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
    $alat = Alat::where('status', 'tersedia')
        ->orWhere('id', $peminjaman->alat_id) // tambahkan alat yg sedang dipinjam user ini
        ->get();

    return view('peminjaman.edit', compact('peminjaman', 'alat'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validatedData = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'nama_peminjam' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'keperluan' => 'required|string|max:255',
        ]);

        // Pastikan alat tersedia
        $peminjaman->update($validatedData);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }
}
