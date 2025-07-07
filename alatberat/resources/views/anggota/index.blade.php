@extends('layouts.main')

@section('title', 'Anggota')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Anggota</h1>

            @if (auth()->user()->role == 'U')
                <a href="{{ route('anggota.create') }}" class="btn btn-primary mb-4">Tambah Anggota</a>
            @endif

            @forelse($anggota as $index => $item)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-light d-flex align-items-center">
                        <i class="fa fa-user text-primary me-2"></i>
                        <h5 class="mb-0 text-primary">{{ $item->nama }}</h5>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <table class="table table-bordered mb-0">
                            <tr>
                                <th>Nama PT</th>
                                <td>{{ $item->nama_pt }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $item->email }}</td>
                            </tr>
                            <tr>
                                <th>No HP</th>
                                <td>{{ $item->no_hp }}</td>
                            </tr>
                            <tr>
                                <th>Alamat PT</th>
                                <td>{{ $item->alamat }}</td>
                            </tr>
                        </table>

                        <div class="text-center mt-3">
                            <a href="{{ route('anggota.edit', $item->id) }}" class="btn btn-warning px-4">
                                <i class="fa fa-edit me-1"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center">
                    <i class="fa fa-info-circle me-1"></i> Data anggota belum tersedia.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
