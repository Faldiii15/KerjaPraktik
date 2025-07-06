@extends('layouts.main')
@section('content')
<div class="container">
    <h2>Laporan Pemeliharaan Alat</h2>
    <a href="{{ route('laporan.pemeliharaan.pdf') }}" class="btn btn-danger my-3">
      <i class="fa fa-file-pdf-o me-1"></i> Export ke PDF
    </a>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>Alat</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->alat->nama ?? '-' }}</td>
                        <td>{{ $item->tanggal}}</td>
                        <td>{{ $item->catatan }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data Pemeliharaan.</td>
                    </tr>
                @endforelse
        </tbody>
    </table>
    <div class="text-end">
        <p>Total Pemeliharaan: <strong>{{ $data->count() }}</strong></p>
    </div>
</div>
@endsection
