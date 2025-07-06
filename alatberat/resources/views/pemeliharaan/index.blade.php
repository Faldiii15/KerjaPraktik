@extends('layout.main')
@section('title', 'Pemeliharaan Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h3">Pemeliharaan Alat Berat</h1>
            <a href="{{ route('pemeliharaan.create') }}" class="btn btn-primary">Tambah Pemeliharaan</a>
            <table class="table table-bordered table-striped table-hover table-primary align-middle text-center mt-3">
                <thead class="table-primary">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Nama Teknisi</th>
                        <th>Tanggal Pemeliharaan</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemeliharaan as $index => $item)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->alat->nama ?? '-' }}</td>
                            <td>{{ $item->teknisi ?? '-' }}</td>
                            <td>{{ $item->tanggal}}</td>
                            <td class="text">
                                @if($item->status == 'Proses')
                                    <span class="text-warning text-dark">Proses</span>
                                    @elseif($item->status == 'Selesai')
                                        <span class="text-success">Selesai</span>
                                    @else
                                        <span class="text-muted">Tidak Diketahui</span>
                                @endif
                            </td>
                            <td>{{ $item->catatan ?? '-' }}
                        </td>
                            <td class="dropdown text-center">
                                <button type="button" class="btn p-0 hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical fs-5"></i>
                                </button>

                                <div class="dropdown-menu">
                                    <a href="{{ route('pemeliharaan.edit', $item->id) }}" class="dropdown-item text-dark">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty     
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pemeliharaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>      
    </div>
</div>
@endsection
