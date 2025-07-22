<form id="formTambahUnit" method="POST" action="{{ route('unit.store', $alat->id) }}">
    @csrf

    <div class="mb-3">
        <label for="kode_alat" class="form-label">Kode Unit Alat</label>
        <input type="text" name="kode_alat" id="kode_alat" class="form-control" maxlength="20" required>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status Unit</label>
        <select name="status" id="status" class="form-select" required>
            <option value="tersedia" selected>Tersedia</option>
            <option value="dipinjam">Dipinjam</option>
            <option value="diperbaiki">Diperbaiki</option>
        </select>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
