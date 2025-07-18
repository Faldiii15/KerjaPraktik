@extends('layouts.main')

@section('title', 'Alat Berat')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Alat Berat</h1>

    @if (auth()->user()->role == 'A')
        <a href="{{ route('alat.create') }}" class="btn btn-primary mb-3">
            <i ></i> Tambah Alat Berat
        </a>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Alat</th>
                    <th>Kode Alat</th>
                    <th>Jenis</th>
                    <th>Merk</th>
                    <th>Tahun Pembelian</th>
                    <th>Jumlah/Unit</th>
                    @if(auth()->user()->role == 'A')
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($alat as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($item->foto && file_exists(public_path('fotoalat/' . $item->foto)))
                                <img src="{{ asset('fotoalat/' . $item->foto) }}" alt="foto" width="80">
                            @else
                                <img src="{{ asset('fotoalat/genset1.jpg') }}" alt="default" width="80">
                            @endif
                        </td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kode_alat }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td>{{ $item->merek }}</td>
                        <td>{{ $item->tahun_pembelian }}</td>
                        <td>{{ $item->jumlah }}</td>
                        @if(auth()->user()->role == 'A')
                            <td>
                                <a href="{{ route('alat.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data alat berat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

