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

        if ($user->role === 'A' || $user->role === 'K') {
            $peminjaman = Peminjaman::with(['alat', 'anggota.user'])
                ->join('anggotas', 'peminjamen.anggota_id', '=', 'anggotas.id')
                ->orderBy('anggotas.nama_pt')
                ->orderBy('peminjamen.tanggal_pinjam')
                ->select('peminjamen.*')
                ->get();
        } else {
            $anggota = Anggota::where('user_id', $user->id)->first();
            $peminjaman = Peminjaman::with(['alat', 'anggota.user'])
                ->where('anggota_id', $anggota->id)
                ->get();
        }

        return view('peminjaman.index')->with('peminjaman', $peminjaman);
    }

    public function create()
    {
        $alat = Alat::where('jumlah', '>', 0)->get();
        $anggota = Anggota::where('user_id', Auth::id())->first();

        return view('peminjaman.create', compact('alat', 'anggota'));
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
            'jumlah' => 'required|integer|min:1',
        ]);

        $anggota = Anggota::where('user_id', Auth::id())->first();
        if ($val['anggota_id'] != $anggota->id) {
            abort(403, 'Anda tidak berhak mengajukan peminjaman ini.');
        }

        $alat = Alat::find($val['alat_id']);
        if ($alat->jumlah < $val['jumlah']) {
            return back()->withErrors(['jumlah' => 'Jumlah melebihi stok tersedia'])->withInput();
        }

        $val['status_peminjaman'] = 'pending';

        Peminjaman::create($val);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan.');
    }

    public function edit(Peminjaman $peminjaman)
    {
        // Cegah akses jika status bukan pending
        if ($peminjaman->status_peminjaman !== 'pending') {
            abort(403, 'Peminjaman ini sudah diverifikasi dan tidak dapat diedit.');
        }

        $alat = Alat::where('jumlah', '>', 0)
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
            'jumlah' => 'required|integer|min:1',
        ]);

        $anggota = Anggota::where('user_id', Auth::id())->first();
        if ($validatedData['anggota_id'] != $anggota->id) {
            abort(403, 'Anda tidak berhak memperbarui peminjaman ini.');
        }

        $peminjaman->update($validatedData);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function acc(Request $request, $id)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['A', 'K'])) {
            abort(403, 'Anda tidak memiliki izin untuk memproses.');
        }

        $request->validate([
            'status_peminjaman' => 'required|in:Disetujui,ditolak,selesai',
            'alasan_penolakan' => 'nullable|string|max:255',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $status = $request->input('status_peminjaman');
        $alasan = $request->input('alasan_penolakan');
        $alat = $peminjaman->alat;

        if ($status === 'Disetujui') {
            if ($alat->jumlah < $peminjaman->jumlah) {
                return back()->withErrors(['jumlah' => 'Stok alat tidak mencukupi.']);
            }

            $alat->decrement('jumlah', $peminjaman->jumlah);
            $peminjaman->status_peminjaman = 'Disetujui';
            $peminjaman->alasan_penolakan = null;
        }

        if ($status === 'ditolak') {
            $peminjaman->status_peminjaman = 'ditolak';
            $peminjaman->alasan_penolakan = $alasan ?? '-';
        }

        if ($status === 'selesai') {
            $peminjaman->status_peminjaman = 'selesai';
            $alat->increment('jumlah', $peminjaman->jumlah); // Kembalikan stok alat
        }

        $peminjaman->save();
        $alat->save();

        return redirect()->route('peminjaman.index')->with('success', 'Status peminjaman diperbarui.');
    }
    public function updateAlasan(Request $request, $id)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['A', 'K'])) {
            abort(403, 'Tidak memiliki izin.');
        }

        $request->validate([
            'alasan_penolakan' => 'required|string|max:255',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->alasan_penolakan = $request->input('alasan_penolakan');
        $peminjaman->save();

        return redirect()->route('peminjaman.index')->with('success', 'Alasan penolakan berhasil diperbarui.');
    }
}
