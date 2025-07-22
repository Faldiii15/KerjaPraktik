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

        // Autentikasi pengguna
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau password kamu salah.',
            ])->onlyInput('email');
        }

        // Login berhasil, regenerasi session
        $request->session()->regenerate();

        $user = Auth::user();

        // Jika Admin → dashboard
        if ($user->role === 'A') {
            return redirect()->intended('/dashboard');
        }

        // Jika Kepala PT → dashboard
        if ($user->role === 'K') {
            return redirect()->intended('/dashboard');
        }

        // Jika User biasa → cek apakah data anggota lengkap
        if ($user->role === 'U') {
            $anggota = Anggota::where('user_id', $user->id)->first();

            if (!$anggota || !$anggota->nama_pt || !$anggota->no_hp || !$anggota->alamat_pt) {
                // Jika data belum lengkap → arahkan ke form profil
                return redirect()->route('profile.index')->with('success', 'Silakan lengkapi profil Anda terlebih dahulu.');
            }

            // Jika data lengkap → ke halaman alat berat
            return redirect()->intended('/alat');
        }

        // Fallback jika role tidak dikenali
        return redirect('/');
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
