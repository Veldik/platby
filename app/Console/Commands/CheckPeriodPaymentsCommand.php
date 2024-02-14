<?php

namespace App\Console\Commands;

use App\Jobs\SendPaymentRecordJob;
use App\Models\Payment;
use App\Models\PaymentRecord;
use App\Models\PeriodPayment;
use App\Utils\ReplacementUtil;
use Cron\CronExpression;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
                    $description = ReplacementUtil::replace($periodPayment->description ?? "");
                    $payers = $periodPayment->periodPayers;

                    $payment = Payment::create([
                        'title' => $title,
                        'description' => $description ?? null,
                    ]);

                    $this->info("Vytvořena platba: " . $title);

                    foreach ($payers as $payer) {
                        $this->info('Přidávám platbu ' . $title .  ' pro: ' . $payer->payer->fullName());
                        $paymentRecord = PaymentRecord::create([
                            'payer_id' => $payer->payer->id,
                            'payment_id' => $payment['id'],
                            'amount' => $payer['amount'],
                        ]);
                        SendPaymentRecordJob::dispatch($payer->payer->id, $payment['id'], $paymentRecord['id'], $payer['amount']);
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
