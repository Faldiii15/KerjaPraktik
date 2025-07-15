<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Alat;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Admin & Kepala PT bisa lihat semua data
        if ($user->role === 'A' || $user->role === 'K') {
            $peminjaman = Peminjaman::with(['alat', 'anggota.user'])
            ->join('anggotas', 'peminjamen.anggota_id', '=', 'anggotas.id')
            ->orderBy('anggotas.nama_pt')
            ->orderBy('peminjamen.tanggal_pinjam')
            ->select('peminjamen.*') // penting untuk menghindari konflik join
            ->get();
        } else {
            // User hanya lihat data miliknya
            $anggota = Anggota::where('user_id', $user->id)->first();
            $peminjaman = Peminjaman::with(['alat', 'anggota.user'])
                ->where('anggota_id', $anggota->id)
                ->get();
        }

        return view('peminjaman.index')->with('peminjaman', $peminjaman);
    }

    public function create()
    {
        $alat = Alat::where('status', 'tersedia')->get();
        $anggota = Anggota::where('user_id', Auth::id())->first();

        return view('peminjaman.create')
            ->with('alat', $alat)
            ->with('anggota', $anggota);
    }

    public function store(Request $request)
    {
        $val = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'anggota_id' => 'required|exists:anggotas,id',
            'nama_pt' => 'required|string|max:225',
            'nama_peminjam' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'keperluan' => 'required|string|max:255',
        ]);

        // Validasi agar user hanya bisa mengajukan atas nama dirinya
        $anggota = Anggota::where('user_id', Auth::id())->first();
        if ($val['anggota_id'] != $anggota->id) {
            abort(403, 'Anda tidak berhak mengajukan peminjaman ini.');
        }

        // Validasi ketersediaan alat
        $alat = Alat::find($val['alat_id']);
        if ($alat->status !== 'tersedia') {
            return back()->withErrors(['alat_id' => 'Alat tidak tersedia.'])->withInput();
        }

        $val['status_peminjaman'] = 'pending';
        Peminjaman::create($val);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan dan menunggu persetujuan.');
    }

    public function acc(Request $request, $id)
    {
        $user = Auth::user();

        // Hanya Admin & Kepala PT yang boleh ACC
        if (!in_array($user->role, ['A', 'K'])) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }

        $peminjaman = Peminjaman::findOrFail($id);
        $status = $request->input('status_peminjaman');

        if (!in_array($status, ['Disetujui', 'ditolak', 'Dikembalikan'])) {
            return back()->withErrors(['status_peminjaman' => 'Status tidak valid.']);
        }

        $peminjaman->status_peminjaman = $status;
        $peminjaman->save();

        $alat = $peminjaman->alat;
        if ($status === 'Disetujui') {
            $alat->status = 'dipinjam';
        } else {
            $alat->status = 'tersedia';
        }
        $alat->save();

        return redirect()->route('peminjaman.index')->with('success', 'Status peminjaman berhasil diperbarui.');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $alat = Alat::where('status', 'tersedia')
            ->orWhere('id', $peminjaman->alat_id)
            ->get();

        return view('peminjaman.edit', compact('peminjaman', 'alat'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validatedData = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'anggota_id' => 'required|exists:anggotas,id',
            'nama_pt' => 'required|string|max:225',
            'nama_peminjam' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'keperluan' => 'required|string|max:255',
        ]);

        // Validasi agar user hanya bisa ubah miliknya
        $anggota = Anggota::where('user_id', Auth::id())->first();
        if ($validatedData['anggota_id'] != $anggota->id) {
            abort(403, 'Anda tidak berhak memperbarui peminjaman ini.');
        }

        $peminjaman->update($validatedData);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function show(Peminjaman $peminjaman)
    {
        //
    }

    public function destroy(Peminjaman $peminjaman)
    {
        //
    }
}
