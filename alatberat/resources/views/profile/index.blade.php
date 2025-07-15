@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h4>Profil Anda</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(auth()->user()->role === 'A')
        <div class="alert alert-info">
            Anda login sebagai <strong>Admin</strong>.
        </div>
        <table class="table table-bordered">
            <tr>
                <th>Nama</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
        </table>
    @elseif(auth()->user()->role === 'K')
        <div class="alert alert-info">
            Anda login sebagai <strong>Kepala PT</strong>.
        </div>
        <table class="table table-bordered">
            <tr>
                <th>Nama</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
        </table>
    @else
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" value="{{ $user->name }}" readonly>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" value="{{ $user->email }}" readonly>
            </div>

            <div class="mb-3">
                <label for="nama_pt" class="form-label">Nama PT</label>
                <input type="text" name="nama_pt" class="form-control @error('nama_pt') is-invalid @enderror"
                    value="{{ old('nama_pt', $anggota->nama_pt) }}">
                @error('nama_pt')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label">Nomor HP</label>
                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                    value="{{ old('no_hp', $anggota->no_hp) }}">
                @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="alamat_pt" class="form-label">Alamat PT</label>
                <textarea name="alamat_pt" class="form-control @error('alamat_pt') is-invalid @enderror">{{ old('alamat_pt', $anggota->alamat_pt) }}</textarea>
                @error('alamat_pt')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan Profil</button>
        </form>
    @endif
</div>
@endsection
