@extends('layouts.main')
@section('title', 'Laporan Alat Berat')

@section('content')
<div class="container">
    <div class="row">   
        <div class="col-md-12">
            <h1>Laporan Alat Berat</h1>
            @if (auth()->user()->role === 'A')
                <a href="{{ route('laporan.alat.pdf') }}" class="btn btn-danger mb-4">
                    <i class="fa fa-file-pdf-o me-1"></i> Export ke PDF
                </a>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Alat</th>
                            <th>Nama Alat</th>
                            <th>Jenis Alat</th>
                            <th>Merk</th>
                            <th>Tahun Pembelian</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alat as $a)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $a->kode_alat }}</td>
                                <td>{{ $a->nama }}</td>
                                <td>{{ $a->jenis }}</td>
                                <td>{{ $a->merek }}</td>
                                <td>{{ $a->tahun_pembelian }}</td>
                                <td>
                                    @if($a->status == 'tersedia')
                                        <span class="badge bg-success">Tersedia</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($a->status) }}</span>
                                    @endif
                                </td>       
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data alat berat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-end">
                <p>Total Alat Berat: <strong>{{ $alat->count() }}</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection
