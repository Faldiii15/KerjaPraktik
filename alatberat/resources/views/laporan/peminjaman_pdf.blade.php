<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman Alat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table, th, td { border: 1px solid black; padding: 5px; }
        th { background-color: #f0f0f0; }
        .right { text-align: right; }
        .center { text-align: center; }
        .summary { margin-top: 15px; font-size: 12px; }
        .footer { margin-top: 60px; width: 100%; font-size: 12px; text-align: right; }
    </style>
</head>
<body>
    <p class="right">
        Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </p>
    <h3 class="center">LAPORAN PEMINJAMAN ALAT</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Customer</th>
                <th>Perusahaan</th>
                <th>Alat</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Keperluan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->nama_peminjam }}</td>
                <td>{{ $p->nama_pt }}</td>
                <td>{{ $p->alat->nama ?? '-' }}</td>
                <td>{{ $p->tanggal_pinjam }}</td>
                <td>{{ $p->tanggal_kembali }}</td>
                <td>{{ $p->keperluan }}</td>
                <td>{{ ucfirst($p->status_peminjaman) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="summary">
        Total Peminjam: <strong>{{ $peminjaman->count() }}</strong>
    </p>

    <div class="footer">
        Dicetak oleh: {{ $user->name ?? 'Admin' }} <br><br><br>
        TTD: ___________________
    </div>
</body>
</html>
