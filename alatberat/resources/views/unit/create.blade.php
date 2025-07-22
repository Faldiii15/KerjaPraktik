@extends('layouts.main')

@section('title', 'Tambah Unit Alat')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Unit untuk: {{ $alat->nama }}</h1>

    <form action="{{ route('unit.store', $alat->id) }}" method="POST">
        @csrf

        <div class="form-group mt-3">
            <label for="kode_alat">Kode Alat (unik)</label>
            <input type="text" name="kode_alat" id="kode_alat" class="form-control" required maxlength="10">
            @error('kode_alat')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('unit.index', $alat->id) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
