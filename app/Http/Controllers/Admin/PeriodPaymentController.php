<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeriodPaymentPayerRequest;
use App\Http\Requests\StorePeriodPaymentRequest;
use App\Http\Requests\UpdatePeriodPaymentRequest;
use App\Http\Resources\PeriodPaymentResource;
use App\Models\PeriodPayment;

class PeriodPaymentController extends Controller
{
    public function index()
    {
        PeriodPayment::all();
        return PeriodPaymentResource::collection(PeriodPayment::all());
    }

    public function show(PeriodPayment $periodPayment)
    {
        // load the periodPayers relationship
        $periodPayment->load('periodPayers');
        $periodPayment->load('periodPayers.payer');

        return PeriodPaymentResource::make($periodPayment);
    }

    public function store(StorePeriodPaymentRequest $request)
    {
        $validated = $request->validated();

        $periodPayment = PeriodPayment::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'cron_expression' => $validated['cronExpression'],
        ]);

        foreach ($validated['periodPayers'] as $periodPayer) {
            $periodPayment->periodPayers()->create([
                'payer_id' => $periodPayer['payerId'],
                'amount' => $periodPayer['amount'],
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    public function update(PeriodPayment $periodPayment, UpdatePeriodPaymentRequest $request) {
        $validated = $request->validated();

        $periodPayment->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'cron_expression' => $validated['cronExpression'],
        ]);
    }

    public function destroy(PeriodPayment $periodPayment)
    {
        $periodPayment->delete();
    }

    public function addPayer(PeriodPayment $periodPayment, StorePeriodPaymentPayerRequest $request) {
        $validated = $request->validated();

        $periodPayment->periodPayers()->create([
            'payer_id' => $validated['payerId'],
            'amount' => $validated['amount'],
        ]);

        return response()->json(['status' => 'ok']);
    }

}
