@extends('layouts.main')
@section('title', 'Laporan Peminjaman Alat')

@section('content')
<div class="container">
    <h1>Laporan Peminjaman Alat Berat</h1>
    <a href="{{ route('laporan.peminjaman.pdf') }}" class="btn btn-danger mb-3">
        <i class="fa fa-file-pdf-o me-1"></i> Export ke PDF
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Alat</th>
                <th>Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->alat->nama }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->tanggal_pinjam }}</td>
                <td>{{ $item->tanggal_kembali }}</td>
                <td>{{ ucfirst($item->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
