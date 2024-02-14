<?php

namespace App\Jobs;

use App\Mail\PaidCreditEmail;
use App\Mail\PaymentRecordEmail;
use App\Models\Payer;
use App\Models\Payment;
use App\Models\PaymentRecord;
use App\Utils\ReplacementUtil;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPaymentRecordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payerId;
    protected $paymentId;
    protected $paymentRecordId;
    protected $amount;

    public function __construct($payerId, $paymentId, $paymentRecordId, $amount)
    {
        $this->payerId = $payerId;
        $this->paymentId = $paymentId;
        $this->paymentRecordId = $paymentRecordId;
        $this->amount = $amount;
    }

    public function handle()
    {
        $dbPayer = Payer::where('id', $this->payerId)->first();
        $payment = Payment::where('id', $this->paymentId)->first();
        $record = PaymentRecord::where('id', $this->paymentRecordId)->first();

        // Kontrola, zda nemá uživatel dostatek kreditu pro zaplacení
        if ($dbPayer->credits->sum('amount') >= $this->amount) {
            $dbPayer->credits()->create([
                'amount' => -$this->amount,
                'description' => 'withdraw by payment ' . $payment->title,
            ]);

            $data = [
                'title' => $payment->title,
                'credit' => ReplacementUtil::formatCurrency($this->amount),
                'payer' => [
                    'name' => $dbPayer->fullName(),
                    'email' => $dbPayer->email,
                    'credit' => ReplacementUtil::formatCurrency($dbPayer->credits->sum('amount') - $this->amount),
                ]
            ];

            // Změna na zaplaceno
            $record->paid_at = now();
            $record->save();

            Mail::to($dbPayer->email)->send(new PaidCreditEmail($data));
        } else {
            $paymentRecord = [
                'id' => $this->paymentRecordId,
                'title' => $payment->title,
                'description' => $payment->description ?? null,
                'name' => $record->payer->fullName(),
                'email' => $record->payer->email,
                'amount' => $record->amount,
                'account_number' => config('fio.account_number'),
                'variable_symbol' => $record->id,
            ];

            $paymentRecord['qr_code'] = $record->getQRCode();
            $paymentRecord['amount'] = ReplacementUtil::formatCurrency($paymentRecord['amount']);

            Mail::to($paymentRecord['email'])->send(new PaymentRecordEmail($paymentRecord));
        }
    }
}
