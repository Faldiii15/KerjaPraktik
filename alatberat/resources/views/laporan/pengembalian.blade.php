@extends('layouts.main')
@section('title', 'Laporan Pengembalian')

@section('content')
<div class="container">
    <h1 class="mb-3">Laporan Pengembalian Alat</h1>
     @if (auth()->user()->role === 'A')    
        <a href="{{ route('laporan.pengembalian.pdf') }}" class="btn btn-danger mb-3">
            <i class="fa fa-file-pdf-o me-1"></i> Export ke PDF
        </a>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Alat</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Kondisi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengembalian as $kembali)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kembali->peminjaman->nama_peminjam ?? '-' }}</td>
                        <td>{{ $kembali->peminjaman->alat->nama ?? '-' }}</td>
                        <td>{{ $kembali->peminjaman->tanggal_pinjam ?? '-' }}</td>
                        <td>{{ $kembali->peminjaman->tanggal_kembali ?? '-' }}</td>
                        <td>{{ $kembali->tanggal_kembali }}</td>
                        <td>{{ ucfirst($kembali->kondisi_alat) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data pengembalian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="text-end">
        <p>Total Pengembalian: <strong>{{ $pengembalian->count() }}</strong></p>
    </div>
</div>
@endsection
