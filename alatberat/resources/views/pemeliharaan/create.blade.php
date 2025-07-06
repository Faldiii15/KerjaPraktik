@extends('layouts.main')
@section('title', 'Pemeliharaan Alat Berat')

@section('content') 
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Tambah Pemeliharaan Alat Berat</h1>
            <form action="{{ route('pemeliharaan.store') }}" method="POST">
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
                <div class="form-group mt-3">
                    <label for="teknisi">Nama Teknisi</label>
                    <input type="text" name="teknisi" id="teknisi" class="form-control" value="{{ old('teknisi') }}" placeholder="Masukkan Nama Teknisi" required>
                    @error('teknisi')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="tanggal">Tanggal Pemeliharaan</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
                    @error('tanggal')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="">Pilih Status</option>
                        <option value="Proses" {{ old('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                        <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="catatan">Catatan</label>
                    <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
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


