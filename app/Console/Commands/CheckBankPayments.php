<?php

namespace App\Console\Commands;

use App\Mail\PaidSuccessfullyEmail;
use App\Mail\AdminPaidWrongEmail;
use App\Mail\PaidWrongEmail;
use App\Models\PaymentRecord;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use h4kuna\Fio;
use Illuminate\Support\Facades\Mail;

class CheckBankPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bank:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kontrola nově přijatých plateb z banky.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $account = [ "fioAccount" => [
            "account" => config('fio.account_number'),
            "token" => config('fio.token'),
        ]];

        $fioFactory = new Fio\FioFactory($account);

        $fioRead = $fioFactory->createFioRead('fioAccount');

        $list = $fioRead->lastDownload();

        foreach ($list as $transaction) {
            $record = PaymentRecord::where([['id', $transaction->variableSymbol], ['paid_at', null], ['amount', $transaction->amount]])->update(['paid_at' => Carbon::now()]);
            $wrongRecord = PaymentRecord::where([['id', $transaction->variableSymbol], ['paid_at', null]])->first();

            if ($record) {

                $dbPaymentRecord = PaymentRecord::where('id', $transaction->variableSymbol)->first();

                $paymentRecord = [
                    'id' => $dbPaymentRecord->id,
                    'title' => $dbPaymentRecord->payment['title'],
                    'description' => $dbPaymentRecord->payment['description'] ?? null,
                    'name' => $dbPaymentRecord->payer->firstName . ' ' . $dbPaymentRecord->payer->lastName,
                    'email' => $dbPaymentRecord->payer->email,
                    'amount' => $dbPaymentRecord->amount,
                    'account_number' => config('fio.account_number'),
                    'variable_symbol' => $dbPaymentRecord->id,
                ];

                Mail::to($paymentRecord['email'])->send(new PaidSuccessfullyEmail($paymentRecord));
                $this->info('Platba ' . $dbPaymentRecord->id . ' s částkou ' . $paymentRecord['amount'] . 'CZK byla úspěšně zpracována.');
            } else if ($wrongRecord) {
                $dbPaymentRecord = $wrongRecord;

                $paymentRecord = [
                    'id' => $dbPaymentRecord->id,
                    'title' => $dbPaymentRecord->payment['title'],
                    'description' => $dbPaymentRecord->payment['description'] ?? null,
                    'name' => $dbPaymentRecord->payer->firstName . ' ' . $dbPaymentRecord->payer->lastName,
                    'email' => $dbPaymentRecord->payer->email,
                    'amount' => $dbPaymentRecord->amount,
                    'realamount' => $transaction->amount,
                    'account_number' => config('fio.account_number'),
                    'variable_symbol' => $dbPaymentRecord->id,
                ];

                $this->error('Platba ' . $transaction->variableSymbol . ' byla nalezena, ale nemohla být zpracována, protože částka nesouhlasí. Na účet přišla částka ' . $transaction->amount . 'CZK, ale platba byla očekávána v hodnotě ' . $wrongRecord->amount . 'CZK.');
                Mail::to(config('mail.from.address'))->send(new AdminPaidWrongEmail($paymentRecord));
                Mail::to($paymentRecord['email'])->send(new PaidWrongEmail($paymentRecord));


            }
        }

        return Command::SUCCESS;
    }
}
