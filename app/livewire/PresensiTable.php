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
            'totalHariIni' => Presensi::whereDate('created_at', $today)->count(),
            'terlambat'    => Presensi::where('status', 'terlambat')
                                ->whereDate('created_at', $today)
                                ->count(),
            // TAMBAHKAN 'jadwal' di dalam with() agar nama kegiatan bisa dipanggil
            'latest'       => Presensi::with(['santri', 'jadwal'])
                                ->latest()
                                ->limit(10)
                                ->get(),
        ]);
    }
}