@extends('layouts.main')

@section('title', 'Pengembalian Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Tambah Pengembalian Alat Berat</h1>

            <form action="{{ route('pengembalian.store') }}" method="POST">
                @csrf

                {{-- Pilih Peminjaman --}}
                <div class="form-group">
                    <label for="peminjaman_id">Pilih Peminjaman</label>
                    <select class="form-control" id="peminjaman_id" name="peminjaman_id" required>
                        <option value="">Pilih Peminjaman</option>
                        @foreach($peminjaman as $item)
                            <option value="{{ $item->id }}" {{ old('peminjaman_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_peminjam }} - {{ $item->nama_pt }} - {{ $item->alat->nama ?? '-' }} ({{ $item->tanggal_pinjam }} s/d {{ $item->tanggal_kembali }})
                            </option>
                        @endforeach
                    </select>
                    @error('peminjaman_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                {{-- Tanggal Kembali --}}
                <div class="form-group mt-3">
                    <label for="tanggal_kembali">Tanggal Kembali</label>
                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" required>
                    @error('tanggal_kembali')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kondisi Alat --}}
                <div class="form-group mt-3">
                    <label for="kondisi_alat">Kondisi Alat</label>
                    <select class="form-control" id="kondisi_alat" name="kondisi_alat" required>
                        <option value="">Pilih Kondisi Alat</option>
                        <option value="baik" {{ old('kondisi_alat') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak" {{ old('kondisi_alat') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="hilang" {{ old('kondisi_alat') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                    </select>
                    @error('kondisi_alat')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div class="form-group mt-3">
                    <label for="catatan">Catatan</label>
                    <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
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
