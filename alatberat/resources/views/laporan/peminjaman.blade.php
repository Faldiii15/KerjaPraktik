@extends('layouts.main')
@section('title', 'Laporan Peminjaman')

@section('content')
<div class="container">
    <h1 class="mb-3">Laporan Peminjaman Alat</h1>
    <a href="{{ route('laporan.peminjaman.pdf') }}" class="btn btn-danger mb-3">
        <i class="fa fa-file-pdf-o me-1"></i> Export ke PDF
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Perusahaan</th>
                    <th>Nama Alat</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Keperluan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->nama_peminjam }}</td>
                        <td>{{ $p->nama_pt }}</td>
                        <td>{{ $p->alat->nama ?? '-' }}</td>
                        <td>{{ $p->tanggal_pinjam }}</td>
                        <td>{{ $p->tanggal_kembali }}</td>
                        <td>{{ $p->keperluan }}</td>
                        <td><span class="badge bg-info">{{ $p->status_peminjaman }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="text-end">
        <p>Total Peminjam: <strong>{{ $peminjaman->count() }}</strong></p>
    </div>
</div>
@endsection
