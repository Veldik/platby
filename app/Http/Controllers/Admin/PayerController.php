<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePayerRequest;
use App\Http\Requests\UpdatePayerRequest;
use App\Http\Resources\PayerResource;
use App\Models\Payer;

class PayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PayerResource::collection(Payer::with('paymentRecords', 'paymentRecords.payment', 'credits')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePayerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePayerRequest $request)
    {
        $validated = $request->validated();

        $payer = Payer::create($validated);

        return PayerResource::make($payer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payer  $payer
     * @return \Illuminate\Http\Response
     */
    public function show(Payer $payer)
    {
        return PayerResource::make($payer->load('paymentRecords', 'paymentRecords.payment', 'credits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePayerRequest  $request
     * @param  \App\Models\Payer  $payer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePayerRequest $request, Payer $payer)
    {
        $validated = $request->validated();

        $payer->update($validated);

        return PayerResource::make($payer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payer  $payer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payer $payer)
    {
        $payer->delete();

        return response()->json(['status' => 'ok']);
    }
}
