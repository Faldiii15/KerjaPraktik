@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Dashboard</h2>
    <canvas id="dashboardChart" width="400" height="200"></canvas>
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
