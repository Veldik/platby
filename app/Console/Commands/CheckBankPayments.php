<?php

namespace App\Console\Commands;

use App\Mail\CreditAcceptedEmail;
use App\Mail\PaidSuccessfullyEmail;
use App\Mail\AdminPaidWrongEmail;
use App\Mail\PaidWrongEmail;
use App\Models\Credit;
use App\Models\Payer;
use App\Models\PaymentRecord;
use App\Models\User;
use App\Utils\ReplacementUtil;
use Carbon\Carbon;
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
    protected $signature = 'check:bank-payments';

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
        echo "Kontrola nových plateb z banky.\n";
        $account = ["fioAccount" => [
            "account" => config('fio.account_number'),
            "token" => config('fio.token'),
        ]];

        $fioFactory = new Fio\FioFactory($account);

        $fioRead = $fioFactory->createFioRead('fioAccount');

        $list = $fioRead->lastDownload();

        foreach ($list as $transaction) {
            if ($transaction->variableSymbol == null || $transaction->amount < 0) {
                continue;
            }


            // Check if transaction must be processed as credit
            if ($transaction->specificSymbol == "2") {
                $payer = Payer::where('id', $transaction->variableSymbol)->first();

                if ($payer) {
                    Credit::create([
                        'payer_id' => $payer->id,
                        'amount' => $transaction->amount,
                        'description' => "deposit from bank account " . $transaction->toAccount . "/" . $transaction->bankCode,
                    ]);

                    $data = [
                        'amount' => ReplacementUtil::formatCurrency($transaction->amount),
                        'payer' => [
                            'name' => $payer->firstName . ' ' . $payer->lastName,
                            'email' => $payer->email,
                            'credit' => ReplacementUtil::formatCurrency($payer->credits->sum('amount')),
                        ]
                    ];

                    Mail::to($payer->email)->send(new CreditAcceptedEmail($data));
                } else {
                    $this->error('Při zpracování kreditu došlo k chybě. Příjemce s variabilním symbolem ' . $transaction->variableSymbol . ' nebyl nalezen.');
                }
            } else {
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
                        'amount' => ReplacementUtil::formatCurrency($dbPaymentRecord->amount),
                        'account_number' => config('fio.account_number'),
                        'variable_symbol' => $dbPaymentRecord->id,
                    ];

                    Mail::to($paymentRecord['email'])->send(new PaidSuccessfullyEmail($paymentRecord));
                    $this->info('Platba ' . $dbPaymentRecord->id . ' s částkou ' . $paymentRecord['amount'] . ' byla úspěšně zpracována.');
                } else if ($wrongRecord) {
                    $dbPaymentRecord = $wrongRecord;

                    $paymentRecord = [
                        'id' => $dbPaymentRecord->id,
                        'title' => $dbPaymentRecord->payment['title'],
                        'description' => $dbPaymentRecord->payment['description'] ?? null,
                        'name' => $dbPaymentRecord->payer->firstName . ' ' . $dbPaymentRecord->payer->lastName,
                        'email' => $dbPaymentRecord->payer->email,
                        'amount' => ReplacementUtil::formatCurrency($dbPaymentRecord->amount),
                        'realamount' => ReplacementUtil::formatCurrency($transaction->amount),
                        'account_number' => config('fio.account_number'),
                        'variable_symbol' => $dbPaymentRecord->id,
                    ];

                    $this->error('Platba ' . $transaction->variableSymbol . ' byla nalezena, ale nemohla být zpracována, protože částka nesouhlasí. Na účet přišla částka ' . $transaction->amount . 'CZK, ale platba byla očekávána v hodnotě ' . $wrongRecord->amount . 'CZK.');

                    $adminEmails = User::where('role', 'admin')->get()->pluck('email')->toArray();
                    foreach ($adminEmails as $recipient) {
                        Mail::to($recipient)->send(new AdminPaidWrongEmail($paymentRecord));
                    }

                    Mail::to($paymentRecord['email'])->send(new PaidWrongEmail($paymentRecord));
                }
            }
        }

        return Command::SUCCESS;
    }
}
