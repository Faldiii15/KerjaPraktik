@extends('layouts.main')
@section('title', 'Peminjaman Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Tambah Peminjaman Alat Berat</h1>
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="alat_id">Pilih Alat Berat</label>
                    <select class="form-control" id="alat_id" name="alat_id" required>
                        <option value="">Pilih Alat Berat</option>
                        @foreach($alat as $item)
                            <option value="{{ $item->id }}" {{ old('alat_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->kode_alat }} - {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('alat_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>  
                <!-- Nama PT -->
                <div class="form-group mt-3">
                    <label for="nama_pt">Nama PT</label>
                    <input type="text" class="form-control" value="{{ $anggota->nama_pt ?? '' }}" readonly>
                    <input type="hidden" name="nama_pt" value="{{ $anggota->nama_pt ?? '' }}">
                    @error('nama_pt')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                <!-- Nama Peminjam -->
                <div class="form-group mt-3">
                    <label for="nama_peminjam">Nama Peminjam</label>
                    <input type="text" class="form-control" value="{{ $anggota->user->name ?? '' }}" readonly>
                    <input type="hidden" name="nama_peminjam" value="{{ $anggota->user->name ?? '' }}">
                    @error('nama_peminjam')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="form-group mt-3">
                    <label for="alamat">Lokasi PT</label>
                    <input type="text" class="form-control" value="{{ $anggota->alamat_pt ?? '' }}" readonly>
                    <input type="hidden" name="alamat" value="{{ $anggota->alamat_pt ?? '' }}">
                    @error('alamat')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="tanggal_pinjam">Tanggal Pinjam</label>
                    <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
                    @error('tanggal_pinjam')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="tanggal_kembali">Tanggal Kembali</label>
                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required>
                    @error('tanggal_kembali')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="keperluan">Keperluan</label>
                    <input type="text" name="keperluan" id="keperluan" class="form-control" placeholder="Masukkan Keperluan" required>
                    @error('keperluan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                <input type="hidden" name="anggota_id" value="{{ $anggota->id }}">
                
                <button type="submit" class="btn btn-primary mt-4">Simpan</button>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary mt-4">Batal</a>
            </form>
        </div>

    </div>
</div>
@endsection
