<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santris';

    protected $fillable = [
        'nama',
        'uid', // Tetap ada jika kamu ingin simpan cadangan di tabel santri
        'nis',
        'kelas'
    ];

    /**
     * Relasi ke tabel rfid_cards
     * Menghubungkan id di tabel santris ke santri_id di tabel rfid_cards
     */
    public function rfidCard()
    {
        // Parameter kedua adalah foreign key di tabel rfid_cards
        return $this->hasOne(RfidCard::class, 'santri_id');
    }
}

