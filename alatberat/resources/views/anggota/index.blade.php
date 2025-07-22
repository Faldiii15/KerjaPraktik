@extends('layouts.main')

@section('title', 'Data Customer')

@section('content')
<style>
    table th, table td {
        text-align: center;
        vertical-align: middle;
    }

    .aksi-kolom {
        width: 100px;
    }
</style>

<div class="container">
    <h4 class="mb-4">Data Customer</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nama PT</th>
                <th>No HP</th>
                <th>Lokasi PT</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($anggota as $key => $row)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $row->user ? $row->user->name : '-' }}</td>
                    <td>{{ $row->nama_pt }}</td>
                    <td>{{ $row->no_hp }}</td>
                    <td>{{ $row->alamat_pt }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data customer.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
