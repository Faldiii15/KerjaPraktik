<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;

class ProfileController extends Controller
{
    public function index()
    {
        $user = \App\Models\User::find(Auth::id());

        // Hanya untuk role 'U', siapkan data anggota
        $anggota = null;
        if ($user->role === 'U') {
            $anggota = Anggota::firstOrCreate(
                ['user_id' => $user->id],
                ['nama' => $user->name]
            );
        }

        return view('profile.index', compact('user', 'anggota'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Cegah update oleh admin atau kepala PT
        if ($user->role !== 'U') {
            abort(403, 'Anda tidak diizinkan mengubah profil ini.');
        }

        // Validasi data input
        $request->validate([
            'nama_pt' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat_pt' => 'required|string',
        ]);

        // Update atau buat data anggota
        Anggota::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama' => $user->name,
                'nama_pt' => $request->nama_pt,
                'no_hp' => $request->no_hp,
                'alamat_pt' => $request->alamat_pt,
            ]
        );

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
