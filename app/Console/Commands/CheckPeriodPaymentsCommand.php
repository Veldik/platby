<?php

namespace App\Console\Commands;

use App\Mail\PaidCreditEmail;
use App\Mail\PaymentRecordEmail;
use App\Models\Payer;
use App\Models\Payment;
use App\Models\PaymentRecord;
use App\Models\PeriodPayment;
use App\Utils\ReplacementUtil;
use Cron\CronExpression;
use Defr\QRPlatba\QRPlatba;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckPeriodPaymentsCommand extends Command
{
    protected $signature = 'check:period-payments';

    protected $description = 'Kontrola pravidelných plateb.';

    public function handle(): void
    {
        echo "Kontrola pravidelných plateb.\n";

        $periodPayments = PeriodPayment::all();

        foreach ($periodPayments as $periodPayment) {
            $cron = CronExpression::factory($periodPayment->cron_expression);

            $lastExpectedRunTime = $cron->getPreviousRunDate()->getTimestamp();

            if ($periodPayment->last_run < $lastExpectedRunTime) {
                try {
                    $title = ReplacementUtil::replace($periodPayment->title);
                    $description = ReplacementUtil::replace($periodPayment->description);
                    $payers = $periodPayment->periodPayers;

                    $payment = Payment::create([
                        'title' => $title,
                        'description' => $description ?? null,
                    ]);

                    $this->info("Vytvořena platba: " . $title);

                    foreach ($payers as $payer) {
                        $this->info('Přidávám platbu ' . $title .  ' pro: ' . $payer->payer->firstName . ' ' . $payer->payer->lastName);
                        $dbPayer = Payer::where('id', $payer['id'])->first();

                        if ($dbPayer->credits->sum('amount') >= $payer['amount']) {
                            $dbPayer->credits()->create([
                                'amount' => -$payer['amount'],
                                'description' => 'withdraw by payment ' . $title . ' #' . $payment->id,
                            ]);

                            $data = [
                                'title' => $title,
                                'credit' => $payer['amount'],
                                'payer' => [
                                    'name' => $dbPayer->firstName . ' ' . $dbPayer->lastName,
                                    'email' => $dbPayer->email,
                                    'credit' => $dbPayer->credits->sum('amount')-$payer['amount'],
                                ]
                            ];

                            PaymentRecord::create([
                                'payer_id' => $payer['id'],
                                'payment_id' => $payment->id,
                                'amount' => $payer['amount'],
                                'paid_at' => now(),
                            ]);

                            Mail::to($dbPayer->email)->send(new PaidCreditEmail($data));
                        } else {
                            $record = PaymentRecord::create([
                                'payer_id' => $payer['id'],
                                'payment_id' => $payment->id,
                                'amount' => $payer['amount']
                            ]);

                            $paymentRecord = [
                                'id' => $record->id,
                                'title' => $title,
                                'description' => $description ?? null,
                                'name' => $record->payer->firstName . ' ' . $record->payer->lastName,
                                'email' => $record->payer->email,
                                'amount' => $record->amount,
                                'account_number' => config('fio.account_number'),
                                'variable_symbol' => $record->id,
                            ];

                            $qrPlatba = new QRPlatba();
                            $qrPlatba->setAccount($paymentRecord['account_number'])
                                ->setVariableSymbol($paymentRecord['variable_symbol'])
                                ->setMessage($paymentRecord['title'] . ' - ' . $paymentRecord['name'])
                                ->setAmount($paymentRecord['amount'])
                                ->setCurrency('CZK')
                                ->setDueDate(new \DateTime());

                            $paymentRecord['qr_code'] = $qrPlatba->getDataUri();

                            Mail::to($paymentRecord['email'])->send(new PaymentRecordEmail($paymentRecord));
                        }
                    }

                    $periodPayment->last_run = now();
                    $periodPayment->save();
                } catch (\Exception $e) {
                    Log::error("Chyba při spouštění chybějící cron úlohy: " . $e->getMessage());
                }
            }
        }
    }
}
