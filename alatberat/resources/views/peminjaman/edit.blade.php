@extends('layout.main')

@section('title', 'Edit Peminjaman Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Edit Peminjaman Alat Berat</h1>
            <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="alat_id">Pilih Alat Berat</label>
                    <select class="form-control" id="alat_id" name="alat_id" required>
                        <option value="">-- Pilih Alat Berat --</option>
                        @foreach($alat as $item)
                            <option value="{{ $item->id }}" {{ old('alat_id', $peminjaman->alat_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->kode_alat }} - {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('alat_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                <div class="form-group mt-3">
                    <label for="nama_peminjam">Nama Peminjam</label>
                    <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control" value="{{ old('nama_peminjam', $peminjaman->nama_peminjam) }}" required>
                </div>
                <div class="form-group mt-3">
                    <label for="tanggal_pinjam">Tanggal Pinjam</label>
                    <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}" required>
                </div>
                <div class="form-group mt-3">
                    <label for="tanggal_kembali">Tanggal Kembali</label>
                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}" required>
                </div>
                <div class="form-group mt-3">
                    <label for="keperluan">Keperluan</label>
                    <input type="text" name="keperluan" id="keperluan" class="form-control" value="{{ old('keperluan', $peminjaman->keperluan) }}" placeholder="Masukkan Keperluan" required>
                </div>
                </div class="mt-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('alat.index') }}" class="btn btn-transparant">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
