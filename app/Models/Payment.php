<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'title',
        'description'
    ];

    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($payment) {
            $payment->paymentRecords()->delete();
        });
    }

    public function paymentRecords()
    {
        return $this->hasMany(PaymentRecord::class);
    }
}
