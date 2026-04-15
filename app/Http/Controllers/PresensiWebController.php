<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;
use App\Exports\PresensiExport;
use Maatwebsite\Excel\Facades\Excel;

class PresensiWebController extends Controller
{
public function index(Request $request)
{
    // 1. Ambil tanggal dari input filter (misal: 2026-04-15)
    $tanggal = $request->get('tanggal');

    // 2. Buat query dasar dengan relasi santri dan jadwal
    $query = Presensi::with(['santri', 'jadwal']);

    // 3. JIKA ada input tanggal, filter berdasarkan kolom 'tanggal'
    if ($tanggal) {
        $query->whereDate('tanggal', $tanggal);
    } else {
        // JIKA tidak ada filter, tampilkan data hari ini saja sebagai default
        $query->whereDate('tanggal', \Carbon\Carbon::today());
    }

    $logs = $query->orderBy('jam_masuk', 'desc')->get();

    return view('presensi.index', compact('logs', 'tanggal'));
}

public function exportExcel(Request $request) 
{
    $tanggal = $request->get('tanggal') ?? date('Y-m-d');
    return Excel::download(new PresensiExport($tanggal), "Laporan_Presensi_{$tanggal}.xlsx");
}
}