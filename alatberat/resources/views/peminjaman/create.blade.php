@extends('layouts.main')

@section('title', 'Tambah Peminjaman Alat Berat')

@section('content')
<div class="container">
    <h1 class="h3 mb-4">Tambah Peminjaman Alat Berat</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('peminjaman.store') }}">
        @csrf

        {{-- PILIH ALAT --}}
        <div class="mb-3">
            <label for="alat_id" class="form-label">Pilih Alat Berat</label>
            <select name="alat_id" id="alat_id" class="form-select @error('alat_id') is-invalid @enderror" required>
                <option value="">Pilih Alat</option>
                @foreach($alat as $item)
                    <option value="{{ $item->id }}" {{ old('alat_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }} (Tersedia: {{ $item->tersedia_units_count }})
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
            <input type="number" name="jumlah" id="jumlah" min="1" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}" required>
            @error('jumlah')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- UNIT PILIHAN --}}
        <div class="mb-3">
            <label class="form-label">Pilih Kode Alat</label>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10%;">Pilih</th>
                        <th>Kode Alat</th>
                    </tr>
                </thead>
                <tbody id="unitContainer">
                    <tr><td colspan="2" class="text-center text-muted">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

        {{-- IDENTITAS PEMINJAM --}}
        @if(auth()->user()->role === 'A')
            <div class="mb-3">
                <label for="nama_pt" class="form-label">Nama PT</label>
                <input type="text" name="nama_pt" class="form-control @error('nama_pt') is-invalid @enderror" value="{{ old('nama_pt') }}" required>
                @error('nama_pt')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="nama_peminjam" class="form-label">Nama Customer</label>
                <input type="text" name="nama_peminjam" class="form-control @error('nama_peminjam') is-invalid @enderror" value="{{ old('nama_peminjam') }}" required>
                @error('nama_peminjam')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat PT</label>
                <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}" required>
                @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" required>
                @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        @else
            @php $data = $anggota; @endphp
            <input type="hidden" name="anggota_id" value="{{ $data->id }}">
            <input type="hidden" name="nama_pt" value="{{ $data->nama_pt }}">
            <input type="hidden" name="nama_peminjam" value="{{ auth()->user()->name }}">
            <input type="hidden" name="alamat" value="{{ $data->alamat_pt }}">
            <input type="hidden" name="no_hp" value="{{ $data->no_hp }}">

            <div class="mb-3"><label class="form-label">Nama PT</label><input type="text" class="form-control" value="{{ $data->nama_pt }}" readonly></div>
            <div class="mb-3"><label class="form-label">Nama Peminjam</label><input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly></div>
            <div class="mb-3"><label class="form-label">Alamat PT</label><input type="text" class="form-control" value="{{ $data->alamat_pt }}" readonly></div>
            <div class="mb-3"><label class="form-label">No HP</label><input type="text" class="form-control" value="{{ $data->no_hp }}" readonly></div>
        @endif

        {{-- TANGGAL & KEPERLUAN --}}
        <div class="mb-3">
            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="form-control @error('tanggal_pinjam') is-invalid @enderror" required>
            @error('tanggal_pinjam')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="form-control @error('tanggal_kembali') is-invalid @enderror" required>
            @error('tanggal_kembali')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="keperluan" class="form-label">Keperluan</label>
            <input type="text" name="keperluan" class="form-control @error('keperluan') is-invalid @enderror" required>
            @error('keperluan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

{{-- JS AJAX UNIT --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const alatSelect = document.getElementById('alat_id');
        const unitContainer = document.getElementById('unitContainer');
        const jumlahInput = document.getElementById('jumlah');

        function loadUnits(alatId) {
            unitContainer.innerHTML = `<tr><td colspan="2" class="text-muted">Memuat data...</td></tr>`;
            if (!alatId) return;

            fetch(`/peminjaman/get-units/${alatId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        unitContainer.innerHTML = `<tr><td colspan="2" class="text-muted">Tidak ada unit tersedia</td></tr>`;
                        return;
                    }

                    const jumlah = parseInt(jumlahInput.value) || data.length;
                    let html = '';

                    data.slice(0, jumlah).forEach(unit => {
                        html += `
                            <tr>
                                <td><input type="checkbox" name="unit_ids[]" value="${unit.id}" checked></td>
                                <td>${unit.kode_alat}</td>
                            </tr>`;
                    });

                    unitContainer.innerHTML = html;
                })
                .catch(() => {
                    unitContainer.innerHTML = `<tr><td colspan="2" class="text-danger">Gagal memuat unit</td></tr>`;
                });
        }

        alatSelect.addEventListener('change', () => loadUnits(alatSelect.value));
        jumlahInput.addEventListener('input', () => loadUnits(alatSelect.value));
        if (alatSelect.value) loadUnits(alatSelect.value);
    });
</script>
@endsection