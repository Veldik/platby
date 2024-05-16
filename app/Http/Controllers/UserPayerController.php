<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayerAddCreditsRequest;
use App\Http\Resources\CreditResource;
use App\Http\Resources\PayerResource;
use App\Http\Resources\PaymentRecordResource;
use App\Models\PaymentRecord;

class UserPayerController extends Controller
{
    public function show()
    {
        return PayerResource::make(auth()->user()->payer->load('credits', 'paymentRecords'));
    }

    public function payments()
    {
        return PaymentRecordResource::collection(auth()->user()->payer->paymentRecords->load('payment')->sortByDesc('created_at'));
    }

    public function credits()
    {
        return CreditResource::collection(auth()->user()->payer->credits->sortByDesc('created_at'));
    }

    public function addCredits(PayerAddCreditsRequest $request)
    {
        $validated = $request->validated();

        return response()->json(['data' => [
            'qrcode' => auth()->user()->payer->getCreditQRCode($validated['amount'] ?? 0),
            'amount' => $validated['amount'] ?? 0,
            'variableSymbol' => auth()->user()->payer->id,
            'specificSymbol' => '2',
            'accountNumber' => config('fio.account_number'),
        ]]);
    }

    public function payByCredits(PaymentRecord $paymentRecord)
    {
        $paymentRecord = auth()->user()->payer->paymentRecords()->findOrFail($paymentRecord->id);

        if ($paymentRecord->paid_at) {
            return response()->json([
                'message' => 'Platba již byla uhrazena.',
            ], 422);
        }

        if ($paymentRecord->amount > auth()->user()->payer->creditSum()) {
            return response()->json([
                'message' => 'Nedosatek kreditů.',
            ], 422);
        }

        $paymentRecord->payByCredits();

        return response()->json(['status' => 'ok']);
    }

    public function qrCode(PaymentRecord $paymentRecord)
    {
        $paymentRecord = auth()->user()->payer->paymentRecords()->findOrFail($paymentRecord->id);

        return response()->json(['data' => [
            'qrcode' => $paymentRecord->getQRCode(),
            'amount' => $paymentRecord->amount,
            'variableSymbol' => $paymentRecord->id,
            'accountNumber' => config('fio.account_number'),
        ]]);
    }
}
