<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'jam_mulai',
        'jam_selesai'
    ];
}