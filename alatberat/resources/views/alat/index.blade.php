@extends('layout.main')

@section('title', 'Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Alat Berat</h1>
            <a href="{{ route('alat.create') }}" class="btn btn-primary mb-4">Tambah Alat Berat</a>

            <div class="row">
                @forelse($alat as $index => $item)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body bg-light">
                                <h5 class="card-title text-primary">
                                    <i class="fa fa-tools me-2"></i>{{ $item->nama }}
                                </h5>
                                <ul class="list-group list-group-flush small">
                                    <li class="list-group-item"><strong>No:</strong> {{ $index + 1 }}</li>
                                    <li class="list-group-item"><strong>Kode Alat:</strong> {{ $item->kode_alat }}</li>
                                    <li class="list-group-item"><strong>Jenis Alat:</strong> {{ $item->jenis }}</li>
                                    <li class="list-group-item"><strong>Merk:</strong> {{ $item->merek }}</li>
                                    <li class="list-group-item"><strong>Tahun Pembelian:</strong> {{ $item->tahun_pembelian }}</li>
                                    <li class="list-group-item">
                                        <strong>Status:</strong>
                                        @if($item->status == 'tersedia')
                                            <span class="badge bg-success">Tersedia</span>
                                        @elseif($item->status == 'dipinjam')
                                            <span class="badge bg-danger">Dipinjam</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $item->status }}</span>
                                        @endif
                                    </li>
                                </ul>
                                <div class="mt-3">
                                    <a href="{{ route('alat.edit', $item->id) }}" class="btn btn-warning w-100">
                                        <i class="fa fa-edit me-1"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fa fa-info-circle me-1"></i> Data alat berat belum tersedia.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
