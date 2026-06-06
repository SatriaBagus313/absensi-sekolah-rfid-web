<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Presensi;
use Carbon\Carbon;

class DashboardCharts extends Component
{
    public $totalPresensiHariIni;
    public $totalTerlambatHariIni;
    public $targetHari;
    public $dataJumlahPresensi;

    public function updateChartData()
    {
        // 1. Definisikan label hari untuk tren mingguan (Overview)
        $this->targetHari = ['Thu', 'Fri', 'Sat', 'Sun', 'Mon', 'Tue', 'Wed'];
        $this->dataJumlahPresensi = [];

        // Hitung data jumlah presensi berdasarkan hari
        foreach ($this->targetHari as $hari) {
            $this->dataJumlahPresensi[] = Presensi::whereRaw("DATE_FORMAT(created_at, '%a') = ?", [$hari])->count();
        }

        // 2. Hitung total presensi & terlambat hari ini
        $this->totalPresensiHariIni = Presensi::whereDate('created_at', Carbon::today())->count();
        $this->totalTerlambatHariIni = Presensi::whereDate('created_at', Carbon::today())
            ->where('status', 'terlambat')
            ->count();

        // Dispatch event ke JavaScript agar Chart.js langsung update grafiknya
        $this->dispatch('refreshCharts', [
            'totalPresensi' => $this->totalPresensiHariIni,
            'terlambat' => $this->totalTerlambatHariIni,
            'labels' => $this->targetHari,
            'dataOverview' => $this->dataJumlahPresensi
        ]);
    }

    public function mount()
    {
        $this->updateChartData();
    }

    // Menggunakan Inline View agar tidak perlu file Blade terpisah
    public function render()
    {
        return <<<'HTML'
        <div wire:poll.3s="updateChartData">
            </div>
        HTML;
    }
}