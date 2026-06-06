<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data count presensi 7 hari terakhir
        $targetHari = [];
        $dataJumlahPresensi = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i);
            
            // Format label hari untuk Chart (Sen, Sel, Rab, dst.)
            $targetHari[] = $tanggal->translatedFormat('D'); 

            // Hitung jumlah santri yang hadir (status = hadir) di tanggal tersebut
            $count = Presensi::whereDate('created_at', $tanggal->toDateString())
                             ->where('status', 'hadir')
                             ->count();
                             
            $dataJumlahPresensi[] = $count;
        }

        // 2. Hitung total presensi & terlambat hari ini untuk card atas
        $totalPresensiHariIni = Presensi::whereDate('created_at', Carbon::today())->count();
        $totalTerlambatHariIni = Presensi::whereDate('created_at', Carbon::today())
                                         ->where('status', 'terlambat')
                                         ->count();

        return view('dashboard.index', compact(
            'targetHari', 
            'dataJumlahPresensi', 
            'totalPresensiHariIni', 
            'totalTerlambatHariIni'
        ));
    }
}