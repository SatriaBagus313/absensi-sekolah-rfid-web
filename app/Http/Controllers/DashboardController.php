<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $today = Carbon::today();
    
    // Hitung data untuk chart
    $tepatWaktu = Presensi::whereDate('created_at', $today)->where('status', 'hadir')->count();
    $terlambat = Presensi::whereDate('created_at', $today)->where('status', 'terlambat')->count();
    
    // Data dummy untuk chart mingguan
    $dataMingguan = [5, 10, 8, 15, 12, 20, 10]; 

    // Pastikan semua variabel dimasukkan ke compact()
    return view('dashboard.index', compact('tepatWaktu', 'terlambat', 'dataMingguan'));
}
}