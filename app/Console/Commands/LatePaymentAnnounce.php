<?php

namespace App\Console\Commands;

use App\Mail\PaymentLateEmail;
use App\Models\PaymentRecord;
use App\Utils\ReplacementUtil;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class LatePaymentAnnounce extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:late-payment-announce';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Týdenní oznámení o nezaplacených platebách.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $records = PaymentRecord::with('payment')->where([['paid_at', null], ['created_at', '<', Carbon::now()->subDays(7)]])->get();

        $records = $records->groupBy('payer.email');

        foreach ($records as $email => $records) {
            $paymentRecords = [];

            foreach ($records as $record) {
                $paymentRecords[] = [
                    'id' => $record->id,
                    'title' => $record->payment['title'],
                    'description' => $record->payment['description'] ?? null,
                    'name' => $record->payer->fullName(),
                    'email' => $record->payer->email,
                    'amount' => ReplacementUtil::formatCurrency($record->amount),
                    'account_number' => config('fio.account_number'),
                    'variable_symbol' => $record->id,
                    'qr_code' => $record->getQRCode(),
                ];
            }


            Mail::to($email)->send(new PaymentLateEmail($paymentRecords));
        }

        return Command::SUCCESS;
    }
}
