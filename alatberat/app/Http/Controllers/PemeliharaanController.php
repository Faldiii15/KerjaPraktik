<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Pemeliharaan;
use Illuminate\Http\Request;

class PemeliharaanController extends Controller
{
    public function index()
    {
        $pemeliharaan = Pemeliharaan::with('alat')->get();
        return view('pemeliharaan.index', compact('pemeliharaan'));
    }

    public function create()
    {
        $alat = Alat::where('jumlah', '>', 0)->get();
        return view('pemeliharaan.create', compact('alat'));
    }

    public function store(Request $request)
    {
        $val = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'tanggal' => 'required|date',
            'teknisi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'jumlah_unit' => 'required|integer|min:1',
            'biaya_pemeliharaan' => 'required|numeric|min:0',
        ]);

        $alat = Alat::findOrFail($val['alat_id']);

        // Kurangi jumlah stok alat
        if ($alat->jumlah < $val['jumlah_unit']) {
            return back()->withErrors(['jumlah_unit' => 'Jumlah unit melebihi stok yang tersedia.'])->withInput();
        }

        $alat->jumlah -= $val['jumlah_unit'];
        $alat->save();

        Pemeliharaan::create([
            'alat_id' => $val['alat_id'],
            'tanggal' => $val['tanggal'],
            'teknisi' => $val['teknisi'],
            'catatan' => $val['catatan'],
            'jumlah_unit' => $val['jumlah_unit'],
            'biaya_pemeliharaan' => $val['biaya_pemeliharaan'],
            'status' => 'Proses',
        ]);

        return redirect()->route('pemeliharaan.index')->with('success', 'Pemeliharaan berhasil ditambahkan.');
    }

    public function edit(Pemeliharaan $pemeliharaan)
    {
        $alat = Alat::all();
        return view('pemeliharaan.edit', compact('pemeliharaan', 'alat'));
    }

    public function update(Request $request, Pemeliharaan $pemeliharaan)
    {
        $val = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'tanggal' => 'required|date',
            'teknisi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'jumlah_unit' => 'required|integer|min:1',
            'biaya_pemeliharaan' => 'required|numeric|min:0',
        ]);

        $alat = Alat::findOrFail($val['alat_id']);

        // Hitung selisih jumlah unit sebelum dan sesudah
        $selisih = $val['jumlah_unit'] - $pemeliharaan->jumlah_unit;

        // Kalau jumlah baru lebih banyak, cek apakah stok cukup
        if ($selisih > 0 && $alat->jumlah < $selisih) {
            return back()->withErrors(['jumlah_unit' => 'Jumlah unit melebihi stok yang tersedia.'])->withInput();
        }

        // Update jumlah alat berdasarkan selisih
        $alat->jumlah -= $selisih;
        $alat->save();

        // Update data pemeliharaan
        $pemeliharaan->update($val);

        return redirect()->route('pemeliharaan.index')->with('success', 'Data pemeliharaan diperbarui.');
    }


    /**
     * Aksi tombol SELESAI → status jadi “Selesai” dan stok alat dikembalikan
     */
    public function selesai($id)
    {
        $pemeliharaan = Pemeliharaan::findOrFail($id);
        $alat = $pemeliharaan->alat;

        if ($pemeliharaan->status === 'Selesai') {
            return redirect()->back()->with('info', 'Pemeliharaan sudah selesai sebelumnya.');
        }

        $pemeliharaan->status = 'Selesai';
        $pemeliharaan->save();

        $alat->jumlah += $pemeliharaan->jumlah_unit;
        $alat->save();

        return redirect()->route('pemeliharaan.index')->with('success', 'Status pemeliharaan diselesaikan dan jumlah alat diperbarui.');
    }
}
