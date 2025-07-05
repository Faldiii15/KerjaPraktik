@extends('layout.main')

@section('title', 'Pengembalian Alat Berat')

@section('content')
<div class="container">
    <h1 class="h3">Daftar Pengembalian Alat Berat</h1>
    <a href="{{ route('pengembalian.create') }}" class="btn btn-primary">Tambah Pengembalian</a>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Nama Peminjam </th>
                <th>Tanggal Kembali</th>
                <th>Kondisi Alat</th>
                <th>Catatan</th>
                <th>Status Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengembalian as $index => $item)
              <tr>
                  <td>{{ $item->id }}</td>
                  <td>{{ $item->peminjaman_id }}</td>
                  <td>{{ $item->tanggal_kembali }}</td>
                  <td>{{ $item->kondisi_alat }}</td>
                  <td>{{ $item->catatan }}</td>
                  <td>{{ $item->status_pengembalian }}</td>
              </tr>
            @endforeach
            <tr>
                <td colspan="8" class="text-center">Data peminjaman belum tersedia.</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
