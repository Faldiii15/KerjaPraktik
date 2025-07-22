<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Pemeliharaan;
use App\Models\UnitAlatBerat;
use Illuminate\Http\Request;

class PemeliharaanController extends Controller
{
    public function index()
    {
        $pemeliharaan = Pemeliharaan::with(['alat', 'units'])->get();
        return view('pemeliharaan.index', compact('pemeliharaan'));
    }

    public function create()
    {
        $alat = Alat::all();
        return view('pemeliharaan.create', compact('alat'));
    }

    public function store(Request $request)
    {
        $val = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'tanggal' => 'required|date',
            'teknisi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'unit_ids' => 'required|array|min:1',
            'unit_ids.*' => 'exists:unit_alat_berats,id',
            'biaya_pemeliharaan' => 'required|numeric|min:0',
        ]);

        $units = UnitAlatBerat::whereIn('id', $val['unit_ids'])->get();

        foreach ($units as $unit) {
            if ($unit->alat_id != $val['alat_id'] || $unit->status != 'tersedia') {
                return back()->withErrors(['unit_ids' => 'Beberapa unit tidak sesuai atau tidak tersedia.'])->withInput();
            }
        }

        foreach ($units as $unit) {
            $unit->status = 'diperbaiki';
            $unit->save();
        }

        $pemeliharaan = Pemeliharaan::create([
            'alat_id' => $val['alat_id'],
            'tanggal' => $val['tanggal'],
            'teknisi' => $val['teknisi'],
            'catatan' => $val['catatan'],
            'jumlah_unit' => count($val['unit_ids']),
            'biaya_pemeliharaan' => $val['biaya_pemeliharaan'],
            'status' => 'Proses',
        ]);

        $pemeliharaan->units()->attach($val['unit_ids']);

        return redirect()->route('pemeliharaan.index')->with('success', 'Pemeliharaan berhasil ditambahkan.');
    }

    public function edit(Pemeliharaan $pemeliharaan)
    {
        $alat = Alat::all();
        $pemeliharaan->load('units');
        return view('pemeliharaan.edit', compact('pemeliharaan', 'alat'));
    }

    public function update(Request $request, Pemeliharaan $pemeliharaan)
    {
        $val = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'tanggal' => 'required|date',
            'teknisi' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'unit_ids' => 'required|array|min:1',
            'unit_ids.*' => 'exists:unit_alat_berats,id',
            'biaya_pemeliharaan' => 'required|numeric|min:0',
        ]);

        $units = UnitAlatBerat::whereIn('id', $val['unit_ids'])->get();

        foreach ($units as $unit) {
            if ($unit->alat_id != $val['alat_id']) {
                return back()->withErrors(['unit_ids' => 'Unit tidak sesuai dengan alat yang dipilih.'])->withInput();
            }
        }

        // Reset status unit lama
        foreach ($pemeliharaan->units as $oldUnit) {
            $oldUnit->status = 'tersedia';
            $oldUnit->save();
        }

        $pemeliharaan->units()->detach();

        // Update status unit baru
        foreach ($units as $unit) {
            $unit->status = 'diperbaiki';
            $unit->save();
        }

        $pemeliharaan->update([
            'alat_id' => $val['alat_id'],
            'tanggal' => $val['tanggal'],
            'teknisi' => $val['teknisi'],
            'catatan' => $val['catatan'],
            'jumlah_unit' => count($val['unit_ids']),
            'biaya_pemeliharaan' => $val['biaya_pemeliharaan'],
        ]);

        $pemeliharaan->units()->attach($val['unit_ids']);

        return redirect()->route('pemeliharaan.index')->with('success', 'Data pemeliharaan diperbarui.');
    }

    public function selesai($id)
    {
        $pemeliharaan = Pemeliharaan::with('units')->findOrFail($id);

        if ($pemeliharaan->status === 'Selesai') {
            return redirect()->back()->with('info', 'Pemeliharaan sudah selesai sebelumnya.');
        }

        $pemeliharaan->status = 'Selesai';
        $pemeliharaan->save();

        foreach ($pemeliharaan->units as $unit) {
            $unit->status = 'tersedia';
            $unit->save();
        }

        return redirect()->route('pemeliharaan.index')->with('success', 'Status pemeliharaan diselesaikan dan unit tersedia kembali.');
    }

    public function getUnits($alatId)
    {
        $units = UnitAlatBerat::where('alat_id', $alatId)
            ->where('status', 'tersedia')
            ->get();

        return response()->json($units);
    }
}
