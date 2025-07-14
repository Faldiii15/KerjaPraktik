<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Anggota;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi form login
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Cek login: email & password
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau password kamu salah.',
            ])->onlyInput('email');
        }

        // Login sukses → buat ulang session
        $request->session()->regenerate();

        // Jika admin → langsung ke dashboard
        if (Auth::user()->role === 'A') {
            return redirect()->intended('/dashboard');
        }

        if (Auth::user()->role !== 'A') {
            // USER BIASA: cek profil apakah sudah lengkap
            $anggota = Anggota::where('user_id', Auth::id())->first();

            if (!$anggota || !$anggota->nama_pt || !$anggota->no_hp || !$anggota->alamat_pt) {
                // Jika belum lengkap, arahkan ke halaman form profil
                return redirect()->route('profile.index'); // pastikan route ini sesuai
            }
        }
        // Jika profil lengkap → masuk ke alat berat
        return redirect()->intended('/alat');
    }

    /**
     * Logout user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
