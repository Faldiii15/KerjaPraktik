@extends('layout.main')

@section('title', 'Peminjaman Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Tambah Peminjaman Alat Berat</h1>
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf

                <div class="form-group mt-3">
                    <label for="nama_peminjam">Nama Peminjam</label>
                    <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control" placeholder="Masukkan Nama Peminjam" required>
                </div>

                <div class="form-group mt-3">
                    <label for="alat_id">Pilih Alat Berat</label>
                    <select class="form-control" id="alat_id" name="id_alat" required>
                        <option value="">-- Pilih Alat --</option>
                        @foreach($alat as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }} ({{ $item->jenis }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="tanggal_pinjam">Tanggal Pinjam</label>
                    <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
                </div>

                <div class="form-group mt-3">
                    <label for="tanggal_kembali">Tanggal Kembali</label>
                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required>
                </div>

                <div class="form-group mt-3">
                    <label for="keperluan">Keperluan</label>
                    <input type="text" name="keperluan" id="keperluan" class="form-control" placeholder="Masukkan Keperluan" required>
                </div>

                <div class="form-group mt-3">
                    <label for="status_peminjaman">Status Peminjaman</label>
                    <select class="form-control" id="status_peminjaman" name="status_peminjaman" required>
                        <option value="menunggu">Menunggu</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Simpan</button>
            </form>
        </div>

    </div>
</div>
@endsection
