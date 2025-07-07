@extends('layouts.main')

@section('title', 'Tambah Anggota')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Tambah Anggota</h1>
            <form action="{{ route('anggota.store') }}" method="POST">
                @csrf

                <div class="form-group mt-3">
                    <label for="nama_pt">Nama PT</label>
                    <input type="text" class="form-control" id="nama_pt" name="nama_pt" required>
                    @error('nama_pt')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="nama">Nama Anggota</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                    @error('nama')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    @error('email')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="no_hp">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                    @error('no_hp')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="alamat">Alamat PT</label>
                    <textarea name="alamat" class="form-control" id="alamat" rows="3" required></textarea>
                    @error('alamat')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
