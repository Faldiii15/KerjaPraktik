@extends('layout.main')

@section('title', 'Tambah Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Tambah Alat Berat</h1>
            <form action="{{ route('alat.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Alat</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="jenis">Jenis Alat</label>
                    <input type="text" class="form-control" id="jenis" name="jenis" required>
                </div>
                <div class="form-group">
                    <label for="merek">Merek</label>
                    <input type="text" class="form-control" id="merek" name="merek" required>
                </div>
                <div class="form-group">
                    <label for="tahun_pembelian">Tahun Pembelian</label>
                    <input type="number" class="form-control" id="tahun_pembelian" name="tahun_pembelian" required> 
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="rusak">Rusak</option>
                        <option value="dipinjam">Dipinjam</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
