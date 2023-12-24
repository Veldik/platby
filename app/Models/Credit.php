<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = [
        'payer_id',
        'amount',
        'description',
    ];

    public function payer()
    {
        return $this->belongsTo(Payer::class);
    }
}
