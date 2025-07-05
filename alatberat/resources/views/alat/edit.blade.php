@extends('layout.main')

@section('title', 'Edit Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Edit Alat Berat</h1>
            <form action="{{ route('alat.update', $alat['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mt-3">
                    <label for="kode_alat">Kode Alat</label>
                    <input type="text" class="form-control" id="kode_alat" name="kode_alat" value="{{ old('kode_alat', $alat['kode_alat']) }}" maxlength="10" readonly>
                    @error('kode_alat')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="nama">Nama Alat</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $alat['nama']) }}" required>
                    @error('nama')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="jenis">Jenis Alat</label>
                    <input type="text" class="form-control" id="jenis" name="jenis" value="{{ old('jenis', $alat['jenis']) }}" required>
                    @error('jenis')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="merek">Merk</label>
                    <input type="text" class="form-control" id="merek" name="merek" value="{{ old('merek', $alat['merek']) }}" required>
                    @error('merek')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="tahun_pembelian">Tahun Pembelian</label>
                    <input type="number" class="form-control" id="tahun_pembelian" name="tahun_pembelian" value="{{ old('tahun_pembelian', $alat['tahun_pembelian']) }}" required> 
                    @error('tahun_pembelian')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                {{-- <div class="form-group mt-3">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="tersedia" {{ old('status', $alat['status']) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="rusak" {{ old('status', $alat['status']) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="dipinjam" {{ old('status', $alat['status']) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    </select>
                    @error('status')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div> --}}
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('alat.index') }}" class="btn btn-transparant">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
