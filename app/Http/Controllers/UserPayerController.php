<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayerAddCreditsRequest;
use App\Http\Resources\CreditResource;
use App\Http\Resources\PayerResource;
use App\Http\Resources\PaymentRecordResource;

class UserPayerController extends Controller
{
    public function show()
    {
        return PayerResource::make(auth()->user()->payer->load('credits', 'paymentRecords'));
    }

    public function payments()
    {
        return PaymentRecordResource::collection(auth()->user()->payer->paymentRecords->load('payment'));
    }

    public function credits()
    {
        return CreditResource::collection(auth()->user()->payer->credits);
    }

    public function addCredits(PayerAddCreditsRequest $request)
    {
        $validated = $request->validated();

        return response()->json([
            'data' => auth()->user()->payer->getCreditQRCode($validated['amount'] ?? 0),
        ]);
    }

    public function qrCode($paymentRecord)
    {
        $paymentRecord = auth()->user()->payer->paymentRecords()->findOrFail($paymentRecord);

        return response()->json([
            'data' => $paymentRecord->getQRCode(),
        ]);
    }
}