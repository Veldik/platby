<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = [
        'payer_id',
        'amount',
        'description',
    ];

    use HasFactory;

    public function payer()
    {
        return $this->belongsTo(Payer::class);
    }
}
