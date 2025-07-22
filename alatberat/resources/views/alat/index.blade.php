@extends('layouts.main')

@section('title', 'Daftar Alat Berat')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Alat Berat</h1>

    @if (auth()->user()->role == 'A')
        <a href="{{ route('alat.create') }}" class="btn btn-primary mb-3">Tambah Alat Berat</a>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Alat</th>
                    <th>Jenis</th>
                    <th>Merk</th>
                    <th>Tahun Pembelian</th>
                    <th>Jumlah Unit</th>
                    @if(auth()->user()->role == 'A')
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($alat as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ asset('fotoalat/' . ($item->foto ?? 'default.jpg')) }}" width="80">
                        </td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td>{{ $item->merek }}</td>
                        <td>{{ $item->tahun_pembelian }}</td>
                        <td>
                            {{ $item->tersedia_units_count }} unit
                        </td>
                        @if(auth()->user()->role == 'A')
                            <td>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('alat.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="{{ route('unit.index', $item->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye-fill"></i> Lihat Unit
                                    </a>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
