@extends('layouts.main')

@section('title', 'Pengembalian Alat Berat')

@section('content')
<div class="container">
    <h1 class="h3">Daftar Pengembalian Alat Berat</h1>
    
    <a href="{{ route('pengembalian.create') }}" class="btn btn-primary">Tambah Pengembalian</a>

    <table class="table table-bordered table-striped table-hover table-primary align-middle text-center mt-3">
        <thead class="table-primary">
            <tr class="text-center">
                <th>No</th>
                <th>Nama Peminjam</th>
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
                <tr class="text-center">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ optional($item->peminjaman)->nama_peminjam ?? '-' }}</td>
                    <td>{{ optional(optional($item->peminjaman)->alat)->nama ?? '-' }}</td>
                    <td>{{ $item->tanggal_kembali }}</td>
                    <td>{{ ucfirst($item->kondisi_alat) }}</td>
                    <td>{{ $item->catatan ?? '-' }}</td>
                    <td>
                        @if($item->status_pengembalian == 'pending')
                            <span class="text-warning">Pending</span>
                        @elseif($item->status_pengembalian == 'Diterima')
                            <span class="text-success">Diterima</span>
                        @elseif($item->status_pengembalian == 'ditolak')
                            <span class="text-danger">Ditolak</span>
                        @else
                            <span class="text-muted">Tidak Diketahui</span>
                        @endif
                    </td>
                    <td class="dropdown text-center">
                        <button type="button" class="btn p-0 hide-arrow" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical fs-5"></i>
                        </button>

                        <div class="dropdown-menu">
                            <a href="{{ route('pengembalian.edit', $item->id) }}" class="dropdown-item text-dark">Edit</a>
                            @if (auth()->user()->role == 'A') 
                                <form action="{{ route('pengembalian.acc', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="status_pengembalian" value="Diterima" 
                                    class="dropdown-item text-success bg-transparent border-0">Setujui</button>
                                    <button type="submit" name="status_pengembalian" value="ditolak" 
                                    class="dropdown-item text-danger bg-transparent border-0">Tolak</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Data pengembalian belum tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
