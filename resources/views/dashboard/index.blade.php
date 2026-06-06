@extends('layouts.app')

@section('title', 'Dashboard Presensi')

@livewire('dashboard-charts')

@section('content')
<div class="container-fluid">
    <div class="mt-4">
        <livewire:presensi-table />
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Performance</h6>
                    <div style="position: relative; height:250px;">
                        <canvas id="performanceChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Overview Absensi Harian</h6>
                    <div style="position: relative; height:250px;">
                        <canvas id="overviewChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Inisialisasi Performance Chart
        const ctxPerf = document.getElementById('performanceChart').getContext('2d');
        
        // Menampung nilai asli dari Controller
        const totalPresensi = Number("{!! $totalPresensiHariIni !!}");
        const terlambat = Number("{!! $totalTerlambatHariIni !!}");
        
        // Perbaikan logika: Murni tepat waktu didapat dari total presensi dikurangi yang terlambat
        const tepatWaktu = totalPresensi - terlambat;

        new Chart(ctxPerf, {
            type: 'doughnut',
            data: {
                labels: ['Tepat Waktu', 'Terlambat'],
                datasets: [{
                    data: [tepatWaktu, terlambat],
                    backgroundColor: ['#2ecc71', '#f1c40f'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: { 
                    legend: { position: 'bottom' } 
                }
            }
        });

        // 2. Inisialisasi Overview Chart (Garis)
        const ctxOver = document.getElementById('overviewChart').getContext('2d');
        
        const labelHari = {!! json_encode($targetHari) !!};
        const dataJumlah = {!! json_encode($dataJumlahPresensi) !!};

        new Chart(ctxOver, {
            type: 'line',
            data: {
                labels: labelHari,
                datasets: [{
                    label: 'Jumlah Masuk',
                    data: dataJumlah,
                    fill: true,
                    backgroundColor: 'rgba(46, 204, 113, 0.1)',
                    borderColor: '#2ecc71',
                    borderWidth: 3,
                    tension: 0.4,
                    pointBackgroundColor: '#2ecc71'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false } 
                },
                scales: { 
                    y: { 
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    } 
                }
            }
        });
    });
</script>
@endsection