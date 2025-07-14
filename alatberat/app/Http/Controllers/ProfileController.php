<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Anggota;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $anggota = Anggota::firstOrCreate([
            'user_id' => $user->id
        ]);

        return view('profile.index', compact('user', 'anggota'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_pt' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat_pt' => 'required|string',
        ]);

        Anggota::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'nama_pt' => $request->nama_pt,
                'no_hp' => $request->no_hp,
                'alamat_pt' => $request->alamat_pt,
            ]
        );

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}