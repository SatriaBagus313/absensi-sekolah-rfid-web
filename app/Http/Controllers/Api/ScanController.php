<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScanBuffer;

class ScanController extends Controller
{
    // ESP32 kirim UID
    public function store(Request $request)
    {
        ScanBuffer::truncate(); // simpan 1 saja

        ScanBuffer::create([
            'uid' => $request->uid
        ]);

        return response()->json([
            'status' => true
        ]);
    }

    // Dashboard ambil UID terbaru
    public function latest()
    {
        $scan = ScanBuffer::latest()->first();

        return response()->json([
            'uid' => $scan->uid ?? null
        ]);
    }
}
