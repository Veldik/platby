<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodPayment extends Model
{
    protected $fillable = [
        'title',
        'description',
        'cron_expression',
        'last_run',
    ];

    protected $casts = [
        'last_run' => 'timestamp',
    ];

    public function periodPayers()
    {
        return $this->hasMany(PeriodPaymentPayers::class);
    }
}
