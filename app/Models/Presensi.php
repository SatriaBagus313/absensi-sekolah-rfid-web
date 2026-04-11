<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensis';

    protected $fillable = [
        'santri_id',
        'jadwal_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status'
    ];

    // Relasi ke Santri (Sudah ada)
    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    // --- TAMBAHKAN INI JUGA ---
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }
}
