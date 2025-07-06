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
                        <div class="card h-100 shadow-sm">
                            {{-- Gambar alat --}}
                            @if($item->foto && file_exists(public_path('fotoalat/' . $item->foto)))
                                <img src="{{ asset('fotoalat/' . ($item->foto ?? 'default-tool.jpg')) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Foto Alat">

                            @else
                                <img src="{{ asset('fotoalat/genset1.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Default Foto">
                            @endif

                            <div class="card-body bg-light">
                                <h5 class="card-title text-primary">
                                    <i></i>{{ $item->nama }}
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
                                        @elseif($item->status == 'diperbaiki')
                                            <span class="badge bg-info text-dark">Dalam Perbaikan</span>
                                        @elseif($item->status == 'rusak')
                                            <span class="badge bg-warning text-dark">Rusak</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak diketahui</span>
                                        @endif
                                    </li>
                                </ul>

                                <a href="{{ route('alat.edit', $item->id) }}" class="btn btn-warning w-100 mt-3">
                                    <i class="fa fa-edit me-1"></i> Edit
                                </a>
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
