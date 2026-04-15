<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Presensi;
use Carbon\Carbon;

class PresensiTable extends Component
{
    public function render()
    {
        $today = Carbon::today();

        return view('livewire.presensi-table', [
            'totalHariIni' => Presensi::whereDate('tanggal', $today)->count(),
            'terlambat'    => Presensi::where('status', 'terlambat')
                                ->whereDate('tanggal', $today)
                                ->count(),
            'latest'       => Presensi::with(['santri', 'jadwal'])
                                ->whereDate('tanggal', $today) // 
                                ->latest()
                                ->limit(10)
                                ->get(),
        ]);
    }
}