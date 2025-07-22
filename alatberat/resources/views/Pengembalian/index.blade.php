@extends('layouts.main')

@section('title', 'Pengembalian Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h3 mb-4">Daftar Pengembalian Alat Berat</h1>

            @if (auth()->user()->role == 'U' || auth()->user()->role == 'A')    
                <a href="{{ route('pengembalian.create') }}" class="btn btn-primary mb-3">
                    <i></i> Tambah Pengembalian
                </a>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama Customer</th>
                            <th>Nama PT</th>
                            <th>No Telepon</th>
                            <th>Nama Alat</th>
                            <th>Kode Unit</th>
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
                                <td>{{ $item->peminjaman->no_hp ?? '-' }}</td>
                                <td>{{ $item->peminjaman->alat->nama ?? '-' }}</td>
                                <td>
                                    @if ($item->peminjaman->units && count($item->peminjaman->units))
                                        <div class="d-flex flex-column gap-1">
                                            @foreach ($item->peminjaman->units as $unit)
                                                <span class="badge bg-info text-dark px-2 py-1 rounded">{{ $unit->kode_alat }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') : '-' }}</td>
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
                                            <a href="#" role="button" id="dropdownMenu{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical fs-5 text-dark"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu{{ $item->id }}">
                                                <form action="{{ route('pengembalian.acc', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" name="status_pengembalian" value="Diterima" class="dropdown-item text-success bg-transparent border-0">Setujui</button>
                                                    <button type="submit" name="status_pengembalian" value="ditolak" class="dropdown-item text-danger bg-transparent border-0">Tolak</button>
                                                </form>
                                            </ul>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">Data pengembalian belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
