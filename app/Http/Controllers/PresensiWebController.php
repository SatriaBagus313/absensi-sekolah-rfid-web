<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiWebController extends Controller
{
public function index(Request $request)
{
    $query = Presensi::with(['santri', 'jadwal']);

    // Jika ada tanggal yang dipilih, gunakan itu. 
    // Jika tidak ada (baru buka halaman), gunakan hari ini.
    $tanggalPilihan = $request->get('tanggal', date('Y-m-d'));

    $query->whereDate('created_at', $tanggalPilihan);

    $presensi = $query->latest()->paginate(20);

    return view('presensi.index', compact('presensi'));
}
}