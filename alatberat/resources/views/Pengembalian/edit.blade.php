@extends('layouts.main')

@section('title', 'Pengembalian Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Edit Pengembalian Alat Berat</h1>
            <form action="{{ route('pengembalian.update', $pengembalian->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="peminjaman_id">Pilih Peminjaman</label>
                    <select class="form-control" id="peminjaman_id" name="peminjaman_id" required>
                        <option value="">-- Pilih Peminjaman --</option>
                        @foreach($peminjaman as $item)
                            <option value="{{ $item->id }}" {{ old('peminjaman_id', $pengembalian->peminjaman_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_peminjam }} - {{ $item->alat->nama ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                    @error('peminjaman_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                    <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" value="{{ old('tanggal_pengembalian', $pengembalian->tanggal_pengembalian) }}" required>
                </div>
                <div class="form-group mt-3">
                    <label for="catatan">Catatan</label>
                    <textarea class="form-control" id="catatan" name="catatan" rows="3" required>{{ old('catatan', $pengembalian->catatan) }}</textarea>
                    </div>
                <div class="form-group mt-3">
                    <label for="status_pengembalian">Status Pengembalian</label>
                    <select class="form-control" id="status_pengembalian" name="status_pengembalian" required>
                        <option value="pending" {{ old('status_pengembalian', $pengembalian->status_pengembalian) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ old('status_pengembalian', $pengembalian->status_pengembalian) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ old('status_pengembalian', $pengembalian->status_pengembalian) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    @error('status_pengembalian')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pengembalian.index') }}" class="btn btn-transparent">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
                
            