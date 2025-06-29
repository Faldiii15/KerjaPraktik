@extends('layout.main')

@section('title', 'Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Alat Berat</h1>
            <a href="{{ route('alat.create') }}" class="btn btn-primary mb-3">Tambah Alat Berat</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Jenis Alat</th>
                        <th>Merek</th>
                        <th>Tahun Pembelian</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alat as $index => $item)
                        <tr>
                            <td>{{ $index +1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>{{ $item->merek }}</td>
                            <td>{{ $item->tahun_pembelian }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <a href="{{ route('alat.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('alat.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>    
</div>
@endsection