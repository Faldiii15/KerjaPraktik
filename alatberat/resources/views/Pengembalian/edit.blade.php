@extends('layouts.main')

@section('title', 'Edit Pengembalian Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Edit Pengembalian Alat Berat</h1>
            <form action="{{ route('pengembalian.update', $pengembalian->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Tampilkan Nama Peminjam (readonly) --}}
                <div class="form-group mt-3">
                    <label for="nama_peminjam">Nama Peminjam</label>
                    <input type="text" class="form-control" value="{{ $pengembalian->peminjaman->nama_peminjam }}" readonly>
                    <input type="hidden" name="peminjaman_id" value="{{ $pengembalian->peminjaman_id }}">
                </div>

                {{-- Tampilkan Nama Alat (readonly) --}}
                <div class="form-group mt-3">
                    <label for="nama_alat">Nama Alat</label>
                    <input type="text" class="form-control" value="{{ $pengembalian->peminjaman->alat->nama ?? '-' }}" readonly>
                </div>

                {{-- Tanggal Kembali --}}
                <div class="form-group mt-3">
                    <label for="tanggal_kembali">Tanggal Kembali</label>
                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" value="{{ old('tanggal_kembali', $pengembalian->tanggal_kembali) }}" required>
                    @error('tanggal_kembali')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kondisi Alat --}}
                <div class="form-group mt-3">
                    <label for="kondisi_alat">Kondisi Alat</label>
                    <select name="kondisi_alat" id="kondisi_alat" class="form-control" required>
                        <option value="baik" {{ old('kondisi_alat', $pengembalian->kondisi_alat) == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak" {{ old('kondisi_alat', $pengembalian->kondisi_alat) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="hilang" {{ old('kondisi_alat', $pengembalian->kondisi_alat) == 'hilang' ? 'selected' : '' }}>Hilang</option>
                    </select>
                    @error('kondisi_alat')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div class="form-group mt-3">
                    <label for="catatan">Catatan</label>
                    <textarea class="form-control" id="catatan" name="catatan" rows="3" required>{{ old('catatan', $pengembalian->catatan) }}</textarea>
                    @error('catatan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
