@extends('layouts.main')
@section('title', 'Pemeliharaan Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h3">Pemeliharaan Alat Berat</h1>

            <a href="{{ route('pemeliharaan.create') }}" class="btn btn-primary mb-3">Tambah Pemeliharaan</a>

            <table class="table table-bordered table-striped table-hover table-primary align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Nama Teknisi</th>
                        <th>Tanggal Pemeliharaan</th>
                        <th>Jumlah Unit</th>
                        <th>Biaya (Rp)</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemeliharaan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->alat->nama ?? '-' }}</td>
                            <td>{{ $item->teknisi ?? '-' }}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->jumlah_unit }}</td>
                            <td>{{ number_format($item->biaya_pemeliharaan, 0, ',', '.') }}</td>
                            <td>
                                @if($item->status === 'Proses')
                                    <span class="text-warning">Proses</span>
                                @elseif($item->status === 'Selesai')
                                    <span class="text-success">Selesai</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $item->catatan ?? '-' }}</td>
                            <td class="text-center">
                                @if($item->status === 'Proses')
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical fs-5"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('pemeliharaan.edit', $item->id) }}" class="dropdown-item text-dark">Edit</a>
                                            <button type="button" class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#modalSelesai{{ $item->id }}">
                                                Selesai
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">–</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Modal Selesai --}}
                        @if($item->status === 'Proses')
                        <div class="modal fade" id="modalSelesai{{ $item->id }}" tabindex="-1" aria-labelledby="modalSelesaiLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalSelesaiLabel{{ $item->id }}">Konfirmasi Selesai</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menandai pemeliharaan alat <strong>{{ $item->alat->nama }}</strong> sebagai <strong>selesai</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('pemeliharaan.selesai', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success">Ya, Selesai</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data pemeliharaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
