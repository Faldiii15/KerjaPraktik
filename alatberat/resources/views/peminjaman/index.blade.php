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

            @if (auth()->user()->role == 'U')     
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">Tambah Peminjaman</a>
            @endif

            <table class="table table-bordered table-striped table-hover align-middle text-center mt-3">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Jumlah</th>
                        <th>Nama PT</th>
                        <th>Nama Peminjam</th>
                        <th>Lokasi PT</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->alat->nama ?? '-' }}</td>
                            <td>{{ $item->jumlah ?? '-' }}</td>
                            <td>{{ $item->nama_pt ?? '-' }}</td>
                            <td>{{ $item->anggota->user->name ?? '-' }}</td>
                            <td>{{ $item->alamat ?? '-' }}</td>
                            <td>{{ $item->tanggal_pinjam }}</td>
                            <td>{{ $item->tanggal_kembali }}</td>
                            <td>{{ $item->keperluan ?? '-' }}</td>
                            <td>
                                @switch($item->status_peminjaman)
                                    @case('pending')
                                        <span class="text-warning">Pending</span>
                                        @break
                                    @case('Disetujui')
                                        <span class="text-success">Disetujui</span>
                                        @break
                                    @case('ditolak')
                                        <span class="text-danger">Ditolak</span><br>
                                        <button class="btn btn-sm btn-outline-primary mt-1" data-bs-toggle="modal" data-bs-target="#alasanModal-{{ $item->id }}">
                                            Lihat Alasan
                                        </button>

                                        <!-- Modal Lihat Alasan -->
                                        <div class="modal fade" id="alasanModal-{{ $item->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Alasan Penolakan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Alat:</strong> {{ $item->alat->nama }}</p>
                                                        <div class="alert alert-danger">
                                                            {{ $item->alasan_penolakan ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @break
                                    @case('selesai')
                                        <span class="text-primary">Selesai</span>
                                        @break
                                    @case('dikembalikan')
                                        <span class="text-info">Dikembalikan</span>
                                        @break
                                    @default
                                        <span class="text-muted">Tidak Diketahui</span>
                                @endswitch
                            </td>
                            <td>
                                @php
                                    $status = $item->status_peminjaman;
                                    $canEdit = auth()->user()->role === 'U' && $status === 'pending';
                                    $canAcc = (auth()->user()->role === 'A' || auth()->user()->role === 'K') && $status === 'pending';
                                @endphp

                                @if($canEdit || $canAcc)
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical fs-5"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            @if ($canEdit)
                                                <a href="{{ route('peminjaman.edit', $item->id) }}" class="dropdown-item text-dark">Edit</a>
                                            @endif
                                            @if ($canAcc)
                                                <button class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#accModal-{{ $item->id }}">
                                                    ACC / Tolak
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">–</span>
                                @endif

                                {{-- Modal ACC --}}
                                @if ($canAcc)
                                    <div class="modal fade" id="accModal-{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('peminjaman.acc', $item->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Verifikasi Peminjaman</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Setujui atau tolak peminjaman alat <strong>{{ $item->alat->nama }}</strong>:</p>
                                                        <div class="form-group mt-2">
                                                            <label for="status">Status</label>
                                                            <select name="status_peminjaman" class="form-control" required id="statusSelect-{{ $item->id }}" onchange="toggleReasonField('{{ $item->id }}')">
                                                                <option value="">-- Pilih Status --</option>
                                                                <option value="Disetujui">Setujui</option>
                                                                <option value="ditolak">Tolak</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mt-3 d-none" id="reasonField-{{ $item->id }}">
                                                            <label for="alasan_penolakan">Alasan Penolakan</label>
                                                            <textarea name="alasan_penolakan" class="form-control" rows="3" placeholder="Tulis alasan penolakan..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">Data peminjaman belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Script Toggle --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        window.toggleReasonField = function (id) {
            const select = document.getElementById('statusSelect-' + id);
            const reason = document.getElementById('reasonField-' + id);
            if (select && reason) {
                const val = select.value.toLowerCase();
                if (val === 'ditolak') {
                    reason.classList.remove('d-none');
                } else {
                    reason.classList.add('d-none');
                }
            }
        };

        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('shown.bs.modal', function () {
                const id = this.id.replace('accModal-', '');
                toggleReasonField(id);
            });
        });
    });
</script>
@endsection
