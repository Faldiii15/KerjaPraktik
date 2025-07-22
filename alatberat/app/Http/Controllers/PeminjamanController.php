<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\UnitAlatBerat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->role, ['A', 'K'])) {
            $peminjaman = Peminjaman::with(['alat', 'anggota.user', 'units'])
                ->leftJoin('anggotas', 'peminjamen.anggota_id', '=', 'anggotas.id')
                ->orderBy('peminjamen.tanggal_pinjam')
                ->select('peminjamen.*')
                ->get();
        } else {
            $anggota = Anggota::where('user_id', $user->id)->firstOrFail();
            $peminjaman = Peminjaman::with(['alat', 'anggota.user', 'units'])
                ->where('anggota_id', $anggota->id)
                ->get();
        }

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $user = Auth::user();

        $alat = Alat::withCount(['units as tersedia_units_count' => function ($q) {
            $q->where('status', 'tersedia');
        }])->has('units')->get()->filter(fn($item) => $item->tersedia_units_count > 0);

        $anggota = $user->role === 'A'
            ? null
            : Anggota::where('user_id', $user->id)->first();

        return view('peminjaman.create', compact('alat', 'anggota'));
    }

    public function getUnits($alat_id)
    {
        $units = UnitAlatBerat::where('alat_id', $alat_id)
            ->where('status', 'tersedia')
            ->get(['id', 'kode_alat']);

        return response()->json($units);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'keperluan' => 'required|string|max:255',
            'unit_ids' => 'required|array|min:1',
            'unit_ids.*' => 'exists:unit_alat_berats,id',
        ]);

        if (count($validated['unit_ids']) !== (int)$validated['jumlah']) {
            return back()->withErrors(['jumlah' => 'Jumlah unit yang dicentang harus sesuai.'])->withInput();
        }

        if ($user->role === 'U') {
            $anggota = Anggota::where('user_id', $user->id)->firstOrFail();
            $validated['anggota_id'] = $anggota->id;
            $validated['nama_pt'] = $anggota->nama_pt;
            $validated['nama_peminjam'] = $anggota->nama ?? $user->name;
            $validated['alamat'] = $anggota->alamat_pt;
            $validated['no_hp'] = $anggota->no_hp;
        } else {
            $adminInput = $request->validate([
                'nama_pt' => 'required|string|max:255',
                'nama_peminjam' => 'required|string|max:255',
                'alamat' => 'required|string|max:255',
                'no_hp' => 'required|string|max:20',
            ]);
            $validated = array_merge($validated, $adminInput);
            $validated['anggota_id'] = null;
        }

        $validated['status_peminjaman'] = 'pending';

        $peminjaman = Peminjaman::create($validated);
        $peminjaman->units()->attach($validated['unit_ids']);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan.');
    }

    public function edit(Peminjaman $peminjaman)
    {
        if ($peminjaman->status_peminjaman !== 'pending') {
            abort(403, 'Tidak dapat diedit.');
        }

        $alat = Alat::with(['units' => fn($q) => $q->where('status', 'tersedia')])
            ->orWhere('id', $peminjaman->alat_id)
            ->get();

        $peminjaman->load('units');

        return view('peminjaman.edit', compact('peminjaman', 'alat'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'keperluan' => 'required|string|max:255',
            'unit_ids' => 'required|array|min:1',
            'unit_ids.*' => 'exists:unit_alat_berats,id',
        ]);

        if (count($validated['unit_ids']) !== (int)$validated['jumlah']) {
            return back()->withErrors(['jumlah' => 'Jumlah unit yang dicentang harus sesuai.'])->withInput();
        }

        if ($user->role === 'U') {
            $anggota = Anggota::where('user_id', $user->id)->firstOrFail();
            $validated['anggota_id'] = $anggota->id;
            $validated['nama_pt'] = $anggota->nama_pt;
            $validated['nama_peminjam'] = $anggota->nama ?? $user->name;
            $validated['alamat'] = $anggota->alamat_pt;
            $validated['no_hp'] = $anggota->no_hp;
        } else {
            $adminInput = $request->validate([
                'nama_pt' => 'required|string|max:255',
                'nama_peminjam' => 'required|string|max:255',
                'alamat' => 'required|string|max:255',
                'no_hp' => 'required|string|max:20',
            ]);
            $validated = array_merge($validated, $adminInput);
            $validated['anggota_id'] = null;
        }

        $peminjaman->update($validated);
        $peminjaman->units()->sync($validated['unit_ids']);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function acc(Request $request, $id)
    {
        $request->validate([
            'status_peminjaman' => 'required|in:Disetujui,ditolak,selesai',
            'alasan_penolakan' => 'nullable|string|max:255',
        ]);

        $peminjaman = Peminjaman::with('units')->findOrFail($id);
        $status = $request->status_peminjaman;

        if ($status === 'Disetujui') {
            $peminjaman->status_peminjaman = 'Disetujui';
            $peminjaman->alasan_penolakan = null;
            foreach ($peminjaman->units as $unit) {
                $unit->status = 'dipinjam';
                $unit->save();
            }
        } elseif ($status === 'ditolak') {
            $peminjaman->status_peminjaman = 'ditolak';
            $peminjaman->alasan_penolakan = $request->alasan_penolakan ?? '-';
        } elseif ($status === 'selesai') {
            $peminjaman->status_peminjaman = 'selesai';
            foreach ($peminjaman->units as $unit) {
                $unit->status = 'tersedia';
                $unit->save();
            }
        }

        $peminjaman->save();
        return redirect()->route('peminjaman.index')->with('success', 'Status diperbarui.');
    }

    public function updateAlasan(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:255',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->alasan_penolakan = $request->alasan_penolakan;
        $peminjaman->save();

        return redirect()->route('peminjaman.index')->with('success', 'Alasan diperbarui.');
    }
}
