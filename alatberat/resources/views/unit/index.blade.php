@extends('layouts.main')

@section('title', 'Daftar Unit Alat - ' . $alat->nama)

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Unit - {{ $alat->nama }}</h1>

    @if (auth()->user()->role == 'A')
        <a href="{{ route('unit.create', $alat->id) }}" class="btn btn-primary mb-3">
            Tambah Unit Alat
        </a>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Kode Alat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($alat->units as $index => $unit)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $unit->kode_alat }}</td>
                        <td>
                            @if ($unit->status == 'tersedia')
                                <span class="badge bg-success">Tersedia</span>
                            @elseif ($unit->status == 'dipinjam')
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            @elseif ($unit->status == 'diperbaiki')
                                <span class="badge bg-danger">Diperbaiki</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Belum ada unit untuk alat ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <a href="{{ route('alat.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Alat</a>
</div>
@endsection
