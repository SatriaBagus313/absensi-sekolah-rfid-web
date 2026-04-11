<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Api\PresensiController;
use App\Models\ScanBuffer;

Route::post('/rfid-scan', function (Request $request) {
    // Menghapus scan lama dan menyimpan yang paling baru
    ScanBuffer::truncate(); 
    ScanBuffer::create(['uid' => $request->uid]);
    return response()->json(['status' => 'success']);
});

// ESP32 kirim UID
Route::post('/scan', function(Request $request){

    Cache::put('last_uid', $request->uid, 60);

    return response()->json([
        'status' => true
    ]);
});


// Dashboard mengambil UID terakhir
Route::get('/scan-rfid', function(){

    return response()->json([
        'uid' => Cache::pull('last_uid')
    ]);
});


// ================= PRESENSI RFID =================

Route::post('/presensi', [PresensiController::class, 'store']);


// ================= USER AUTH (DEFAULT) =================

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
