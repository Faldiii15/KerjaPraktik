<!DOCTYPE html>
<html>
<head>
    <title>Laporan Alat Berat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; padding: 5px; }
        th { background-color: #f0f0f0; }
        .right { text-align: right; font-size: 11px; }
        .center { text-align: center; }
        .summary { margin-top: 15px; font-size: 12px; }
        .footer { margin-top: 60px; width: 100%; font-size: 12px; text-align: right; }
    </style>
</head>
<body>
    <p class="right">
        Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </p>

    <h2 class="center">LAPORAN DATA ALAT BERAT</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Alat</th>
                <th>Kode Unit & Status</th>
                <th>Jenis</th>
                <th>Merk</th>
                <th>Tahun</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alat as $a)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $a->nama }}</td>
                <td>
                    @foreach($a->units as $unit)
                        • {{ $unit->kode_alat }} ({{ ucfirst($unit->status) }})<br>
                    @endforeach
                </td>
                <td>{{ $a->jenis }}</td>
                <td>{{ $a->merek }}</td>
                <td>{{ $a->tahun_pembelian }}</td>
                <td>{{ $a->units->count() }} unit</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="summary">
        Total Alat Berat: <strong>{{ $alat->count() }}</strong>
    </p>

    <div class="footer">
        Dicetak oleh: {{ $user->name ?? 'Admin' }} <br><br><br>
        TTD: ___________________
    </div>
</body>
</html>
