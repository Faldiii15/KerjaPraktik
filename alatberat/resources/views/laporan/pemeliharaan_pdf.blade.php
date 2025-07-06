<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pemeliharaan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background: #f2f2f2; }
        .right { text-align: right; }
        .center { text-align: center; }
        .summary { margin-top: 15px; font-size: 12px; }
        .footer { margin-top: 60px; width: 100%; font-size: 12px; text-align: right; }
    </style>
</head>
<body>
    <p class="right">Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    <h3 style="text-align: center;">LAPORAN PEMELIHARAAN ALAT</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Alat</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->alat->nama ?? '-' }}</td>
                <td>{{ $item->tanggal}}</td>
                <td>{{ $item->deskripsi }}</td>
                <td>{{ ucfirst($item->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="summary">
        Total Peminjam: <strong>{{ $data->count() }}</strong>
    </p>

    <div class="footer">
        Dicetak oleh: {{ $user->name ?? 'Admin' }} <br><br><br>
        TTD: ___________________
    </div>
</body>
</html>
