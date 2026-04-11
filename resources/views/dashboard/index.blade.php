@extends('layouts.app')

@section('title', 'Dashboard Presensi')

@section('content')


    <div class="mt-4">
        <livewire:presensi-table />
    </div>
</div>

<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="fw-bold">Performance</h6>
                    <canvas id="performanceChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="fw-bold">Overview Absensi Harian</h6>
                    <canvas id="overviewChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Performance Chart
        const ctxPerf = document.getElementById('performanceChart').getContext('2d');
        new Chart(ctxPerf, {
            type: 'doughnut',
            data: {
                labels: ['Tepat Waktu', 'Terlambat'],
                datasets: [{
                    data: [{{ $tepatWaktu }}, {{ $terlambat }}],
                    backgroundColor: ['#2ecc71', '#f1c40f'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // 2. Overview Chart
        const ctxOver = document.getElementById('overviewChart').getContext('2d');
        new Chart(ctxOver, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Jumlah Masuk',
                    data: @json($dataMingguan),
                    fill: true,
                    backgroundColor: 'rgba(46, 204, 113, 0.2)',
                    borderColor: '#2ecc71',
                    tension: 0.4
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
@endsection