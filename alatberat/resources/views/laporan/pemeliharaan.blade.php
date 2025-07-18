@extends('layouts.main')
@section('content')
<div class="container">
    <h2>Laporan Pemeliharaan Alat</h2>

    @if (auth()->user()->role === 'A')
        <a href="{{ route('laporan.pemeliharaan.pdf') }}" class="btn btn-danger my-3">
            <i class="fa fa-file-pdf-o me-1"></i> Export ke PDF
        </a>
    @endif

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>Alat</th>
                <th>Teknisi</th>
                <th>Tanggal</th>
                <th>Jumlah Unit</th>
                <th>Biaya (Rp)</th>
                <th>Catatan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->alat->nama ?? '-' }}</td>
                    <td>{{ $item->teknisi }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->jumlah_unit }}</td>
                    <td>{{ number_format($item->biaya_pemeliharaan, 0, ',', '.') }}</td>
                    <td>{{ $item->catatan }}</td>
                    <td>
                        @if($item->status === 'Selesai')
                            <span class="text-success">Selesai</span>
                        @else
                            <span class="text-warning">Proses</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data Pemeliharaan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="text-end">
        <p>Total Pemeliharaan: <strong>{{ $data->count() }}</strong></p>
    </div>
</div>
@endsection
