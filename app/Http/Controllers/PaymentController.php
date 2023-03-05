<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Mail\PaymentRecordEmail;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\PaymentRecord;
use Illuminate\Support\Facades\Mail;
use Defr\QRPlatba\QRPlatba;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PaymentResource::collection(Payment::with('paymentRecords', 'paymentRecords.payer')->get());
    }

    public function store(StorePaymentRequest $request)
    {
        $validated = $request->validated();

        $payment = Payment::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ]);

        foreach ($validated['payers'] as $payer) {
            $record = PaymentRecord::create([
                'payer_id' => $payer['id'],
                'payment_id' => $payment->id,
                'amount' => $payer['amount']
            ]);

            $paymentRecord = [
                'id' => $record->id,
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
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

        return response()->json(['status' => 'ok']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json(['status' => 'ok']);
    }
}
