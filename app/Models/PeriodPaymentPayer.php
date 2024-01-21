<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodPaymentPayer extends Model
{
    protected $fillable = [
        'payer_id',
        'amount',
    ];

    use HasFactory;

    public function payer()
    {
        return $this->belongsTo(Payer::class);
    }
}
