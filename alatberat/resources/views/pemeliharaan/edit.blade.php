@extends('layouts.main')
@section('title', 'Edit Pemeliharaan Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Edit Pemeliharaan Alat Berat</h1>
            <form action="{{ route('pemeliharaan.update', $pemeliharaan->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Pilih Alat --}}
                <div class="form-group">
                    <label for="alat_id">Pilih Alat Berat</label>
                    <select class="form-control" id="alat_id" name="alat_id" required>
                        @foreach($alat as $item)
                            <option value="{{ $item->id }}" {{ old('alat_id', $pemeliharaan->alat_id) == $item->id ? 'selected' : '' }}>
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
                    <input type="text" name="teknisi" id="teknisi" class="form-control" value="{{ old('teknisi', $pemeliharaan->teknisi) }}" placeholder="Masukkan Nama Teknisi" required>
                    @error('teknisi')   
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Pemeliharaan --}}
                <div class="form-group mt-3">
                    <label for="tanggal">Tanggal Pemeliharaan</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', $pemeliharaan->tanggal) }}" required>
                    @error('tanggal')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                {{-- Jumlah Unit --}}
                <div class="form-group mt-3">
                    <label for="jumlah_unit">Jumlah Unit</label>
                    <input type="number" name="jumlah_unit" id="jumlah_unit" class="form-control" value="{{ old('jumlah_unit', $pemeliharaan->jumlah_unit) }}" min="1" required>
                    @error('jumlah_unit')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Biaya Pemeliharaan --}}
                <div class="form-group mt-3">
                    <label for="biaya_pemeliharaan">Biaya Pemeliharaan (Rp)</label>
                    <input type="number" name="biaya_pemeliharaan" id="biaya_pemeliharaan" class="form-control" value="{{ old('biaya_pemeliharaan', $pemeliharaan->biaya_pemeliharaan) }}" min="0" required>
                    @error('biaya_pemeliharaan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div class="form-group mt-3">
                    <label for="catatan">Catatan</label>
                    <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan', $pemeliharaan->catatan) }}</textarea>
                    @error('catatan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pemeliharaan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
