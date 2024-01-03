<?php

namespace App\Models;

use App\Utils\ReplacementUtil;
use Cron\CronExpression;
use Illuminate\Database\Eloquent\Model;

class PeriodPayment extends Model
{
    protected $fillable = [
        'title',
        'description',
        'cron_expression',
        'last_run',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($query) {
            $query->orderBy('created_at', 'desc');
        });

        static::deleting(function ($periodPayment) {
            $periodPayment->periodPayers()->delete();
        });
    }

    protected $casts = [
        'last_run' => 'timestamp',
    ];

    public function periodPayers()
    {
        return $this->hasMany(PeriodPaymentPayer::class);
    }

    public function nextRun()
    {
        $cron = CronExpression::factory($this->cron_expression);
        return $cron->getNextRunDate()->getTimestamp();
    }

    public function displayTitle() {
        return ReplacementUtil::replace($this->title);
    }

    public function displayDescription() {
        if (empty($this->description)) {
            return '';
        }
        return ReplacementUtil::replace($this->description);
    }
}
