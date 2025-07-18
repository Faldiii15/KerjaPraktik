@extends('layouts.main')
@section('title', 'Pemeliharaan Alat Berat')

@section('content') 
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Tambah Pemeliharaan Alat Berat</h1>
            <form action="{{ route('pemeliharaan.store') }}" method="POST">
                @csrf

                {{-- Pilih Alat --}}
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

                {{-- Nama Teknisi --}}
                <div class="form-group mt-3">
                    <label for="teknisi">Nama Teknisi</label>
                    <input type="text" name="teknisi" id="teknisi" class="form-control" value="{{ old('teknisi') }}" placeholder="Masukkan Nama Teknisi" required>
                    @error('teknisi')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div class="form-group mt-3">
                    <label for="tanggal">Tanggal Pemeliharaan</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
                    @error('tanggal')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                {{-- Jumlah Unit --}}
                <div class="form-group mt-3">
                    <label for="jumlah_unit">Jumlah Unit yang Diperbaiki</label>
                    <input type="number" name="jumlah_unit" id="jumlah_unit" class="form-control" min="1" value="{{ old('jumlah_unit') }}" required>
                    @error('jumlah_unit')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                {{-- Biaya Pemeliharaan --}}
                <div class="form-group mt-3">
                    <label for="biaya_pemeliharaan">Biaya Pemeliharaan (Rp)</label>
                    <input type="number" name="biaya_pemeliharaan" id="biaya_pemeliharaan" class="form-control" min="0" value="{{ old('biaya_pemeliharaan') }}" required>
                    @error('biaya_pemeliharaan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                {{-- Catatan --}}
                <div class="form-group mt-3">
                    <label for="catatan">Catatan</label>
                    <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pemeliharaan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
