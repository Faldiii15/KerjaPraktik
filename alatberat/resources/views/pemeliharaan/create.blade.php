@extends('layouts.main')
@section('title', 'Pemeliharaan Alat Berat')

@section('content') 
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Tambah Pemeliharaan Alat Berat</h1>
            <form action="{{ route('pemeliharaan.store') }}" method="POST">
                @csrf

                {{-- Pilih Alat --}}
                <div class="form-group">
                    <label for="alat_id">Pilih Alat Berat</label>
                    <select class="form-control" id="alat_id" name="alat_id" required onchange="loadUnits(this.value)">
                        <option value="">Pilih Alat Berat</option>
                        @foreach($alat as $item)
                            <option value="{{ $item->id }}" {{ old('alat_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->kode_alat }} - {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('alat_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                {{-- Daftar Unit --}}
                <div id="unit_container" class="mt-4"></div>

                {{-- Nama Teknisi --}}
                <div class="form-group mt-3">
                    <label for="teknisi">Nama Teknisi</label>
                    <input type="text" name="teknisi" id="teknisi" class="form-control" value="{{ old('teknisi') }}" placeholder="Masukkan Nama Teknisi" required>
                    @error('teknisi')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div class="form-group mt-3">
                    <label for="tanggal">Tanggal Pemeliharaan</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
                    @error('tanggal')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                {{-- Biaya --}}
                <div class="form-group mt-3">
                    <label for="biaya_pemeliharaan">Biaya Pemeliharaan (Rp)</label>
                    <input type="number" name="biaya_pemeliharaan" id="biaya_pemeliharaan" class="form-control" min="0" value="{{ old('biaya_pemeliharaan') }}" required>
                    @error('biaya_pemeliharaan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>  
                    @enderror
                </div>

                {{-- Catatan --}}
                <div class="form-group mt-3">
                    <label for="catatan">Catatan</label>
                    <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pemeliharaan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script AJAX load unit --}}
<script>
function loadUnits(alatId) {
    const container = document.getElementById('unit_container');
    container.innerHTML = '<p class="text-muted">Memuat data unit...</p>';

    if (!alatId) {
        container.innerHTML = '';
        return;
    }

    fetch(`/pemeliharaan/units/${alatId}`)
        .then(res => res.json())
        .then(data => {
            if (data.length === 0) {
                container.innerHTML = '<div class="alert alert-warning">Tidak ada unit tersedia.</div>';
                return;
            }

            let html = `<label>Pilih Kode Unit</label><div class="row">`;
            data.forEach(unit => {
                html += `
                    <div class="col-md-4">
                        <div class="form-check border p-2 rounded bg-light">
                            <input class="form-check-input" type="checkbox" name="unit_ids[]" value="${unit.id}" id="unit_${unit.id}">
                            <label class="form-check-label" for="unit_${unit.id}">
                                ${unit.kode_alat}
                            </label>
                        </div>
                    </div>`;
            });
            html += '</div>';
            container.innerHTML = html;
        })
        .catch(() => {
            container.innerHTML = '<div class="alert alert-danger">Gagal mengambil data unit.</div>';
        });
}
</script>
@endsection
