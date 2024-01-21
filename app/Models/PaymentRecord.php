<?php

namespace App\Models;

use App\Mail\PaidCreditEmail;
use App\Utils\ReplacementUtil;
use Defr\QRPlatba\QRPlatba;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class PaymentRecord extends Model
{
    protected $fillable = [
        'payer_id',
        'payment_id',
        'amount',
        'paid_at',
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

    public function payByCredits()
    {
        $this->payer->credits()->create([
            'amount' => -$this->amount,
            'description' => 'withdraw by payment ' . $this->payment->title,
        ]);

        $emailData = [
            'title' => $this->payment->title,
            'credit' => ReplacementUtil::formatCurrency($this->amount),
            'payer' => [
                'name' => $this->payer->fullName(),
                'email' => $this->payer->email,
                'credit' => ReplacementUtil::formatCurrency($this->payer->creditSum()),
            ]
        ];

        Mail::to($emailData["payer"]["email"])->send(new PaidCreditEmail($emailData));

        $this->paid_at = now();
        $this->save();

        return $this;
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
