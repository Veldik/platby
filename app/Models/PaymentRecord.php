<?php

namespace App\Models;

use Defr\QRPlatba\QRPlatba;
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
    public function getQRCode()
    {
        $qrPlatba = new QRPlatba();
        $qrPlatba->setAccount(config('fio.account_number'))
            ->setVariableSymbol($this->id)
            ->setMessage($this->payment->title . ' - ' . $this->payer->firstName . ' ' . $this->payer->lastName)
            ->setAmount($this->amount)
            ->setCurrency('CZK')
            ->setDueDate(new \DateTime());

        return $qrPlatba->getDataUri();
    }
}
