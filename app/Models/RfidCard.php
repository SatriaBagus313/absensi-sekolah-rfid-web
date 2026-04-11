<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfidCard extends Model
{
    protected $table = 'rfid_cards'; //

    protected $fillable = [
        'santri_id',
        'uid'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }
}