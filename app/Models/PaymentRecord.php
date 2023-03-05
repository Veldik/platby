<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    protected $fillable = [
        'payer_id',
        'payment_id',
        'amount',
    ];

    use HasFactory;

    public function payer()
    {
        return $this->belongsTo(Payer::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
