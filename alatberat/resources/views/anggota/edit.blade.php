@extends('layouts.main')

@section('title', 'Edit Anggota')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-4">Edit Data Anggota</h1>

            <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="nama_pt">Nama PT</label>
                    <input type="text" name="nama_pt" id="nama_pt" class="form-control" value="{{ old('nama_pt', $anggota->nama_pt) }}" required>
                    @error('nama_pt')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $anggota->nama) }}" required>
                    @error('nama')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="email">Alamat Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $anggota->email) }}" required>
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="no_hp">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp', $anggota->no_hp) }}" required>
                    @error('no_hp')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="alamat">Alamat PT</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', $anggota->alamat) }}</textarea>
                    @error('alamat')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
