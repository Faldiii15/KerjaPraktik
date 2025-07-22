<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\UnitAlatBerat;
use Illuminate\Http\Request;

class UnitAlatController extends Controller
{
    public function index($alat_id)
    {
        $alat = Alat::with('units')->findOrFail($alat_id);
        return view('unit.index', compact('alat'));
    }

    public function create($alat_id)
    {
        $alat = Alat::findOrFail($alat_id);
        return view('unit.create', compact('alat'));
    }

    public function store(Request $request, $alat_id)
    {
        $request->validate([
            'kode_alat' => 'required|unique:unit_alat_berats,kode_alat',
        ]);

        UnitAlatBerat::create([
            'alat_id' => $alat_id,
            'kode_alat' => $request->kode_alat,
            'status' => 'tersedia',
        ]);

        return redirect()->route('unit.index', $alat_id)->with('success', 'Unit alat berhasil ditambahkan.');
    }
}
