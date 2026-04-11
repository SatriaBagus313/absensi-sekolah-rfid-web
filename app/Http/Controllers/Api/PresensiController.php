<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RfidCard;
use App\Models\Presensi;
use App\Models\Jadwal;
use App\Models\Santri;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function store(Request $request)
    {
        try {

            // =============================
            // VALIDASI REQUEST
            // =============================
            if (!$request->uid) {
                return response()->json([
                    'status' => false,
                    'message' => 'UID kosong'
                ], 400);
            }

            $uid = strtolower(trim($request->uid));

            // =============================
            // 1. CEK KARTU RFID
            // =============================
            $card = RfidCard::where('uid', $uid)->first();

            if (!$card) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kartu tidak terdaftar'
                ], 404);
            }

            // =============================
            // 2. AMBIL SANTRI
            // =============================
            $santri = Santri::find($card->santri_id);

            if (!$santri) {
                return response()->json([
                    'status' => false,
                    'message' => 'Santri tidak ditemukan'
                ], 404);
            }

            // =============================
            // 3. WAKTU SEKARANG
            // =============================
            $now = Carbon::now();
            $tanggal = $now->toDateString();
            $jamSekarang = $now->format('H:i:s');

            // =============================
            // 4. CARI JADWAL AKTIF
            // =============================
            $jadwal = Jadwal::where('jam_mulai', '<=', $jamSekarang)
                ->where('jam_selesai', '>=', $jamSekarang)
                ->first();

            if (!$jadwal) {
                return response()->json([
                    'status' => false,
                    'message' => 'Diluar jam kegiatan'
                ], 200);
            }

            // =============================
            // 5. CEK PRESENSI HARI INI
            // =============================
            $presensi = Presensi::where('santri_id', $santri->id)
                ->where('jadwal_id', $jadwal->id)
                ->where('tanggal', $tanggal)
                ->first();

            // =============================
            // 6. ABSEN MASUK + CEK TERLAMBAT
            // =============================
            if (!$presensi) {

                // ===== HITUNG TERLAMBAT =====
                $jamMulai = Carbon::parse($jadwal->jam_mulai);
                $batasToleransi = $jamMulai->copy()->addMinutes(5);

                $statusKehadiran = 'hadir';

                if ($now->greaterThan($batasToleransi)) {
                    $statusKehadiran = 'terlambat';
                }

                Presensi::create([
                    'santri_id' => $santri->id,
                    'jadwal_id' => $jadwal->id,
                    'tanggal' => $tanggal,
                    'jam_masuk' => $now->format('H:i:s'),
                    'status' => $statusKehadiran
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Absen '.$jadwal->nama_kegiatan.' berhasil',
                    'nama' => $santri->nama,
                    'kegiatan' => $jadwal->nama_kegiatan,
                    'kehadiran' => $statusKehadiran // <-- TAMBAHAN
                ]);
            }

            // =============================
            // 7. ABSEN PULANG
            // =============================
            if (!$presensi->jam_pulang) {

                $presensi->update([
                    'jam_pulang' => $now->format('H:i:s')
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Pulang '.$jadwal->nama_kegiatan.' berhasil',
                    'nama' => $santri->nama,
                    'kegiatan' => $jadwal->nama_kegiatan,
                    'kehadiran' => $presensi->status
                ]);
            }

            // =============================
            // 8. SUDAH ABSEN
            // =============================
            return response()->json([
                'status' => false,
                'message' => 'Sudah absen kegiatan ini'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}