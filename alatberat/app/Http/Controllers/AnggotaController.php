<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Tampilkan daftar anggota yang berasal dari user login (role: U)
     */
    public function index()
    {
        $anggota = Anggota::with('user')
            ->whereNotNull('user_id') // hanya data dari user login
            ->whereHas('user', function ($q) {
                $q->where('role', 'U'); // hanya user biasa
            })
            ->orderBy('id', 'asc')
            ->get();

        return view('anggota.index', compact('anggota'));
    }
}
