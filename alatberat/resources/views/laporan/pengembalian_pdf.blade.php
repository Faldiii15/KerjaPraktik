<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengembalian Alat</title>
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
    <h3 align="center">LAPORAN PENGEMBALIAN ALAT</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Alat</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Tgl Pengembalian</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengembalian as $kembali)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kembali->peminjaman->nama_peminjam ?? '-' }}</td>
                <td>{{ $kembali->peminjaman->alat->nama ?? '-' }}</td>
                <td>{{ $kembali->peminjaman->tanggal_pinjam ?? '-' }}</td>
                <td>{{ $kembali->peminjaman->tanggal_kembali ?? '-' }}</td>
                <td>{{ $kembali->tanggal_kembali }}</td>
                <td>{{ ucfirst($kembali->kondisi_alat) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="summary">
        Total Pengembalian: <strong>{{ $pengembalian->count() }}</strong>
    </p>

    <div class="footer">
        Dicetak oleh: {{ $user->name ?? 'Admin' }} <br><br><br>
        TTD: ___________________
    </div>
</body>
</html>
