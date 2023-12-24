<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payer extends Model
{
    protected $fillable = [
        'firstName',
        'lastName',
        'email'
    ];

    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($payer) {
            $payer->paymentRecords()->delete();
        });
    }

    public function paymentRecords()
    {
        return $this->hasMany(PaymentRecord::class);
    }

    public function credits()
    {
        return $this->hasMany(Credit::class);
    }
}
