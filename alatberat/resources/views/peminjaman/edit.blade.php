@extends('layouts.main')
@section('title', 'Edit Peminjaman Alat Berat')

@section('content')
<div class="container">
    <h1 class="h3 mb-4">Edit Peminjaman Alat Berat</h1>

    <form method="POST" action="{{ route('peminjaman.update', $peminjaman->id) }}">
        @csrf
        @method('PUT')

        {{-- PILIH ALAT --}}
        <div class="mb-3">
            <label for="alat_id" class="form-label">Pilih Alat Berat</label>
            <select name="alat_id" id="alat_id" class="form-select" required>
                @foreach($alat as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $peminjaman->alat_id ? 'selected' : '' }}>
                        {{ $item->nama }} (Stok: {{ $item->units->where('status', 'tersedia')->count() }})
                    </option>
                @endforeach
            </select>
            @error('alat_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- JUMLAH --}}
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Unit yang Ingin Dipinjam</label>
            <input type="number" name="jumlah" id="jumlah" min="1" class="form-control"
                value="{{ $peminjaman->jumlah }}" required>
                @error('jumlah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
        </div>

        {{-- PILIH UNIT --}}
        <div class="mb-3">
            <label class="form-label">Pilih Unit Alat (Kode)</label>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10%;">Pilih</th>
                        <th>Kode Alat</th>
                    </tr>
                </thead>
                <tbody id="unitContainer">
                    <tr><td colspan="2" class="text-muted text-center">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

        {{-- IDENTITAS PEMINJAM --}}
        <input type="hidden" name="anggota_id" value="{{ $peminjaman->anggota_id }}">
        <input type="hidden" name="nama_pt" value="{{ $peminjaman->nama_pt }}">
        <input type="hidden" name="nama_peminjam" value="{{ $peminjaman->nama_peminjam }}">
        <input type="hidden" name="alamat" value="{{ $peminjaman->alamat }}">
        <input type="hidden" name="no_hp" value="{{ $peminjaman->no_hp }}">

        <div class="mb-3"><label>Nama PT</label><input type="text" class="form-control" value="{{ $peminjaman->nama_pt }}" readonly></div>
        <div class="mb-3"><label>Nama Customer</label><input type="text" class="form-control" value="{{ $peminjaman->nama_peminjam }}" readonly></div>
        <div class="mb-3"><label>Alamat PT</label><input type="text" class="form-control" value="{{ $peminjaman->alamat }}" readonly></div>
        <div class="mb-3"><label>No HP</label><input type="text" class="form-control" value="{{ $peminjaman->no_hp }}" readonly></div>

        {{-- TANGGAL --}}
        <div class="mb-3">
            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="form-control"
                value="{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('Y-m-d') }}" required>
                @error('tanggal_pinjam')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="form-control"
                value="{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('Y-m-d') }}" required>
                @error('tanggal_kembali')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
        </div>

        {{-- KEPERLUAN --}}
        <div class="mb-3">
            <label for="keperluan" class="form-label">Keperluan</label>
            <input type="text" name="keperluan" class="form-control" value="{{ $peminjaman->keperluan }}" required>
            @error('keperluan')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- SUBMIT --}}
        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

{{-- AJAX Unit Loader --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const alatSelect = document.getElementById('alat_id');
        const unitContainer = document.getElementById('unitContainer');
        const jumlahInput = document.getElementById('jumlah');

        // Ambil unit yang sudah dipilih sebelumnya dari controller (diberikan ke JS)
        const selectedUnitIds = @json($peminjaman->units->pluck('id'));

        function loadUnits(alatId) {
            unitContainer.innerHTML = `<tr><td colspan="2" class="text-muted text-center">Memuat data...</td></tr>`;
            if (!alatId) return;

            fetch(`/peminjaman/get-units/${alatId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        unitContainer.innerHTML = `<tr><td colspan="2" class="text-center text-muted">Tidak ada unit tersedia</td></tr>`;
                        return;
                    }

                    const jumlah = parseInt(jumlahInput.value) || data.length;
                    let html = '';

                    data.slice(0, jumlah).forEach(unit => {
                        const isChecked = selectedUnitIds.includes(unit.id) ? 'checked' : '';
                        html += `
                            <tr>
                                <td><input type="checkbox" name="unit_ids[]" value="${unit.id}" ${isChecked}></td>
                                <td>${unit.kode_alat}</td>
                            </tr>`;
                    });

                    unitContainer.innerHTML = html;
                })
                .catch(() => {
                    unitContainer.innerHTML = `<tr><td colspan="2" class="text-danger text-center">Gagal memuat unit</td></tr>`;
                });
        }

        alatSelect.addEventListener('change', () => loadUnits(alatSelect.value));
        jumlahInput.addEventListener('input', () => loadUnits(alatSelect.value));
        if (alatSelect.value) loadUnits(alatSelect.value); // Initial load
    });
</script>
@endsection
