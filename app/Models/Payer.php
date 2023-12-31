<?php

namespace App\Models;

use Defr\QRPlatba\QRPlatba;
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

    public function fullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function credits()
    {
        return $this->hasMany(Credit::class);
    }

    public function creditSum()
    {
        return $this->credits->sum('amount');
    }

    public function getCreditQRCode($amount = 0)
    {
        $qrPlatba = new QRPlatba();
        $qrPlatba->setAccount(config('fio.account_number'))
            ->setVariableSymbol($this->id)
            ->setSpecificSymbol(2)
            ->setMessage('Kredity' . ' - ' . $this->fullName())
            ->setCurrency('CZK')
            ->setDueDate(new \DateTime());

        if ($amount) {
            $qrPlatba->setAmount($amount);
        }

        return $qrPlatba->getDataUri();
    }

}
