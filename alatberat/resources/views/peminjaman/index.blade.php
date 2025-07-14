@extends('layouts.main')

@section('title', 'Peminjaman Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h3">Peminjaman Alat Berat</h1>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- | auth()->user()->role == 'A' --}}
            @if (auth()->user()->role == 'U')     
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">Tambah Peminjaman</a>
            @endif
            <table class="table table-bordered table-striped table-hover table-primary align-middle text-center mt-3">
                <thead class="table-primary">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Nama PT</th>
                        <th>Nama Peminjam</th>
                        <th>Alamat</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $index => $item)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->alat->nama ?? '-' }}</td>
                            <td>{{ $item->nama_pt ?? '-' }}</td>
                            <td>{{ $item->anggota->user->name ?? '-' }}</td>
                            <td>{{ $item->alamat ?? '-' }}</td>
                            <td>{{ $item->tanggal_pinjam }}</td>
                            <td>{{ $item->tanggal_kembali }}</td>
                            <td>{{ $item->keperluan ?? '-' }}</td>
                            <td class="text">
                                @if($item->status_peminjaman == 'pending')
                                    <span class="text-warning">Pending</span>
                                @elseif($item->status_peminjaman == 'Disetujui')
                                    <span class="text-succes">Disetujui</span>
                                @elseif($item->status_peminjaman == 'ditolak')
                                    <span class="text-danger">Ditolak</span>
                                @elseif($item->status_peminjaman == 'dikembalikan')
                                    <span class="text-primary">selesai</span>
                                @else
                                    <span class="text-muted">Tidak Diketahui</span>
                                @endif
                            </td>
                            <td class="dropdown text-center">
                                    <button type="button" class="btn p-0 hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical fs-5"></i>
                                    </button>

                                    <div class="dropdown-menu">
                                        <a href="{{ route('peminjaman.edit', $item->id) }}" class="dropdown-item text-dark">Edit</a>
                                        @if (auth()->user()->role == 'A') 
                                            <form action="{{ route('peminjaman.acc', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" name="status_peminjaman" value="Disetujui" 
                                                class="dropdown-item text-success bg-transparent border-0">Setujui</button>
                                                <button type="submit" name="status_peminjaman" value="ditolak" 
                                                class="dropdown-item text-danger bg-transparent border-0">Tolak</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Data peminjaman belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
