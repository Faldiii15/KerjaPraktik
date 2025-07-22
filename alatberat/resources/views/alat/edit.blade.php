@extends('layouts.main')

@section('title', 'Edit Alat Berat')

@section('content')
<div class="container">
    <h1>Edit Alat Berat</h1>
    <form action="{{ route('alat.update', $alat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mt-3">
            <label for="nama">Nama Alat</label>
            <input type="text" class="form-control" id="nama" name="nama"
                value="{{ old('nama', $alat->nama) }}" required>
            @error('nama')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="jenis">Jenis Alat</label>
            <input type="text" class="form-control" id="jenis" name="jenis"
                value="{{ old('jenis', $alat->jenis) }}" required>
            @error('jenis')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="merek">Merk</label>
            <input type="text" class="form-control" id="merek" name="merek"
                value="{{ old('merek', $alat->merek) }}" required>
            @error('merek')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="tahun_pembelian">Tahun Pembelian</label>
            <input type="number" class="form-control" id="tahun_pembelian" name="tahun_pembelian"
                value="{{ old('tahun_pembelian', $alat->tahun_pembelian) }}" required>
            @error('tahun_pembelian')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="foto">Foto Alat</label><br>
            @if($alat->foto && file_exists(public_path('fotoalat/' . $alat->foto)))
                <img src="{{ asset('fotoalat/' . $alat->foto) }}" alt="Foto Alat" width="150" class="mb-2"><br>
                <p><strong>File saat ini:</strong> {{ $alat->foto }}</p>
            @else
                <p class="text-muted">Belum ada foto</p>
            @endif

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
@endsection
