@extends('layouts.main')

@section('title', 'Pengembalian Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h3">Daftar Pengembalian Alat Berat</h1>

            @if (auth()->user()->role == 'U')    
                <a href="{{ route('pengembalian.create') }}" class="btn btn-primary mb-3">
                    Tambah Pengembalian
                </a>
            @endif

            <table class="table table-bordered table-striped table-hover table-primary align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Nama PT</th>
                        <th>Nama Alat</th>
                        <th>Tanggal Kembali</th>
                        <th>Kondisi Alat</th>
                        <th>Catatan</th>
                        <th>Status Pengembalian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengembalian as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->peminjaman->nama_peminjam ?? '-' }}</td>
                            <td>{{ $item->peminjaman->nama_pt ?? '-' }}</td>
                            <td>{{ $item->peminjaman->alat->nama ?? '-' }}</td>
                            <td>{{ $item->tanggal_kembali ?? '-' }}</td>
                            <td>{{ ucfirst($item->kondisi_alat ?? '-') }}</td>
                            <td>{{ $item->catatan ?? '-' }}</td>
                            <td>
                                @switch($item->status_pengembalian)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                        @break
                                    @case('Diterima')
                                        <span class="badge bg-success">Diterima</span>
                                        @break
                                    @case('ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">Tidak Diketahui</span>
                                @endswitch
                            </td>
                            <td>
                                @if(auth()->user()->role == 'A' && $item->status_pengembalian === 'pending')
                                    <div class="dropdown text-center">
                                        <button type="button" class="btn p-0" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical fs-5"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <form action="{{ route('pengembalian.acc', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" name="status_pengembalian" value="Diterima" 
                                                    class="dropdown-item text-success bg-transparent border-0">Setujui</button>
                                                <button type="submit" name="status_pengembalian" value="ditolak" 
                                                    class="dropdown-item text-danger bg-transparent border-0">Tolak</button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Data pengembalian belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
