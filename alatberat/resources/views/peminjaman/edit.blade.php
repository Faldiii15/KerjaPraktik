@extends('layouts.main')

@section('title', 'Edit Peminjaman Alat Berat')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Edit Peminjaman Alat Berat</h1>

            <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Pilih Alat Berat -->
                <div class="form-group">
                    <label for="alat_id">Pilih Alat Berat</label>
                    <select class="form-control" id="alat_id" name="alat_id" required>
                        <option value="">-- Pilih Alat Berat --</option>
                        @foreach($alat as $item)
                            <option 
                                value="{{ $item->id }}" 
                                data-stok="{{ $item->jumlah }}"
                                {{ old('alat_id', $peminjaman->alat_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->kode_alat }} - {{ $item->nama }} (Stok: {{ $item->jumlah }})
                            </option>
                        @endforeach
                    </select>
                    @error('alat_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jumlah -->
                <div class="form-group mt-3">
                    <label for="jumlah">Jumlah Unit yang Ingin Dipinjam</label>
                    <input type="number" id="jumlah" name="jumlah" class="form-control" min="1"
                        value="{{ old('jumlah', $peminjaman->jumlah) }}" required>
                    @error('jumlah')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama PT -->
                <div class="form-group mt-3">
                    <label for="nama_pt">Nama PT</label>
                    <input type="text" class="form-control" value="{{ $peminjaman->nama_pt }}" readonly>
                    <input type="hidden" name="nama_pt" value="{{ $peminjaman->nama_pt }}">
                    @error('nama_pt')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama Peminjam -->
                <div class="form-group mt-3">
                    <label for="nama_peminjam">Nama Peminjam</label>
                    <input type="text" class="form-control" value="{{ $peminjaman->nama_peminjam }}" readonly>
                    <input type="hidden" name="nama_peminjam" value="{{ $peminjaman->nama_peminjam }}">
                    @error('nama_peminjam')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lokasi PT -->
                <div class="form-group mt-3">
                    <label for="alamat">Lokasi PT</label>
                    <input type="text" class="form-control" value="{{ $peminjaman->alamat }}" readonly>
                    <input type="hidden" name="alamat" value="{{ $peminjaman->alamat }}">
                    @error('alamat')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Pinjam -->
                <div class="form-group mt-3">
                    <label for="tanggal_pinjam">Tanggal Pinjam</label>
                    <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam"
                        value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}" required>
                    @error('tanggal_pinjam')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Kembali -->
                <div class="form-group mt-3">
                    <label for="tanggal_kembali">Tanggal Kembali</label>
                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali"
                        value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}" required>
                    @error('tanggal_kembali')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keperluan -->
                <div class="form-group mt-3">
                    <label for="keperluan">Keperluan</label>
                    <input type="text" name="keperluan" id="keperluan" class="form-control"
                        value="{{ old('keperluan', $peminjaman->keperluan) }}" placeholder="Masukkan Keperluan" required>
                    @error('keperluan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Anggota ID -->
                <input type="hidden" name="anggota_id" value="{{ $peminjaman->anggota_id }}">

                <!-- Tombol Aksi -->
                <button type="submit" class="btn btn-primary mt-4">Simpan</button>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary mt-4">Batal</a>
            </form>
        </div>
    </div>
</div>

{{-- Script untuk batasi jumlah berdasarkan stok alat --}}
<script>
    document.getElementById('alat_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const maxStok = selectedOption.getAttribute('data-stok');
        const jumlahInput = document.getElementById('jumlah');
        jumlahInput.max = maxStok;
    });

    // trigger saat pertama kali (jika sudah terisi)
    window.addEventListener('DOMContentLoaded', () => {
        const selected = document.querySelector('#alat_id option:checked');
        if (selected) {
            const maxStok = selected.getAttribute('data-stok');
            if (maxStok) {
                document.getElementById('jumlah').max = maxStok;
            }
        }
    });
</script>
@endsection
