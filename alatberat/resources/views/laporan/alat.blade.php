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
                            <th>Nama Alat</th>
                            <th>Kode Unit & Status</th>
                            <th>Jenis Alat</th>
                            <th>Merk</th>
                            <th>Tahun Pembelian</th>
                            <th>Jumlah/Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alat as $a)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start">{{ $a->nama }}</td>
                            <td class="text-start">
                                @forelse($a->units as $unit)
                                    <div>
                                        <span class="badge 
                                            {{ $unit->status == 'tersedia' ? 'bg-success' : ($unit->status == 'dipinjam' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                            {{ $unit->kode_alat }} ({{ ucfirst($unit->status) }})
                                        </span>
                                    </div>
                                @empty
                                    <span class="text-muted">Tidak ada unit</span>
                                @endforelse
                            </td>
                            <td>{{ $a->jenis }}</td>
                            <td>{{ $a->merek }}</td>
                            <td>{{ $a->tahun_pembelian }}</td>
                            <td><span class="badge bg-info text-dark">{{ $a->units->count() }} unit</span></td>
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
