@extends('layouts.main')

@section('content')
<div class="container text-center my-4">
    <h2 class="text-primary fw-bold">{{ $profil['nama_pt'] }}</h2>
    <div class="row mt-4">
        <div class="col-md-6 text-start">
            <h4 class="fw-bold">Visi</h4>
            <ul>
                @foreach ($profil['visi'] as $visi)
                    <li style="text-align: justify">{{ $visi }}</li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-6 text-start">
            <h4 class="fw-bold">Misi</h4>
            <ul>
                @foreach ($profil['misi'] as $misi)
                    <li style="text-align: justify">{{ $misi }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <hr>
</div>

<div class="container mb-5">
    <h3 class="text-center fw-bold mb-3">Grafik Total Laporan</h3>
    <canvas id="dashboardChart" width="400" height="180" class="mb-4"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    const dashboardChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Alat Berat', 'Peminjaman', 'Pengembalian', 'Pemeliharaan'],
            datasets: [{
                label: 'Jumlah',
                data: [
                    {{ $jumlahAlat }},
                    {{ $jumlahPeminjaman }},
                    {{ $jumlahPengembalian }},
                    {{ $jumlahPemeliharaan }}
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 99, 132, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>
@endsection
