<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodPaymentPayers extends Model
{
    protected $fillable = [
        'payer_id',
        'amount',
    ];

    public function payer()
    {
        return $this->belongsTo(Payer::class);
    }
}
