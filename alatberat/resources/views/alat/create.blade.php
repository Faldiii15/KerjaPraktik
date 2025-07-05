@extends('layout.main')

@section('title', 'Tambah Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Tambah Alat Berat</h1>
            <form action="{{ route('alat.store') }}" method="POST" enctype="multipart/form-data"> {{-- ⬅ Tambahkan ini --}}
                @csrf

                <div class="form-group mt-3">
                    <label for="kode_alat">Kode Alat</label>
                    <input type="text" class="form-control" id="kode_alat" name="kode_alat" maxlength="10" required>
                    @error('kode_alat')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="nama">Nama Alat</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                    @error('nama')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="jenis">Jenis Alat</label>
                    <input type="text" class="form-control" id="jenis" name="jenis" required>
                    @error('jenis')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="merek">Merk</label>
                    <input type="text" class="form-control" id="merek" name="merek" required>
                    @error('merek')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="tahun_pembelian">Tahun Pembelian</label>
                    <input type="number" class="form-control" id="tahun_pembelian" name="tahun_pembelian" required> 
                    @error('tahun_pembelian')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="foto">Foto Alat</label>
                    <input type="file" class="form-control" name="foto" accept="image/*">
                    @error('foto')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('alat.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
