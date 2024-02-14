<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Jobs\SendPaymentRecordJob;
use App\Mail\PaidCreditEmail;
use App\Mail\PaymentRecordEmail;
use App\Mail\PaymentStornoEmail;
use App\Models\Payer;
use App\Models\Payment;
use App\Models\PaymentRecord;
use App\Utils\ReplacementUtil;
use Defr\QRPlatba\QRPlatba;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\QueryBuilder;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $payments = QueryBuilder::for(Payment::class)
            ->with('paymentRecords')
            ->paginate(15);

        return PaymentResource::collection($payments);
    }

    public function show(Payment $payment)
    {
        $payment = Payment::with('paymentRecords', 'paymentRecords.payer')->where('id', $payment->id)->first();

        return PaymentResource::make($payment);
    }

    public function store(StorePaymentRequest $request)
    {
        $validated = $request->validated();

        $payment = Payment::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ]);

        foreach ($validated['payers'] as $payer) {
            $paymentRecord = PaymentRecord::create([
                'payer_id' => $payer['id'],
                'payment_id' => $payment['id'],
                'amount' => $payer['amount'],
            ]);
            SendPaymentRecordJob::dispatch($payer['id'], $payment['id'], $paymentRecord['id'], $payer['amount']);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->paymentRecords()->get()->each(function ($record) {
            $paymentRecord = [
                'id' => $record->id,
                'title' => $record->payment['title'],
                'description' => $record->payment['description'] ?? null,
                'name' => $record->payer->fullName(),
                'email' => $record->payer->email,
                'amount' => ReplacementUtil::formatCurrency($record->amount),
                'account_number' => config('fio.account_number'),
                'variable_symbol' => $record->id,
                'paid_at' => $record->paid_at,
            ];

            if ($record->paid_at) {
                $record->payer->credits()->create([
                    'amount' => $record->amount,
                    'description' => 'deposit by cancellation payment ' . $record->payment['title'],
                ]);
            }

            Mail::to($paymentRecord['email'])->send(new PaymentStornoEmail($paymentRecord));
        });

        $payment->delete();

        return response()->json(['status' => 'ok']);
    }
}
