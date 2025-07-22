<div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Kode Alat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($alat->units as $index => $unit)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $unit->kode_alat }}</td>
                    <td>
                        @switch($unit->status)
                            @case('tersedia')
                                <span class="badge bg-success">Tersedia</span>
                                @break
                            @case('dipinjam')
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                                @break
                            @case('diperbaiki')
                                <span class="badge bg-danger">Diperbaiki</span>
                                @break
                            @default
                                <span class="badge bg-secondary">{{ ucfirst($unit->status) }}</span>
                        @endswitch
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Belum ada unit alat untuk alat ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
