<?php

namespace App\Http\Controllers;

use App\Models\PaymentRecord;
use App\Http\Requests\StorePaymentRecordRequest;
use App\Http\Requests\UpdatePaymentRecordRequest;

class PaymentRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaymentRecordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentRecordRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentRecord  $paymentRecord
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentRecord $paymentRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentRecord  $paymentRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentRecord $paymentRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentRecordRequest  $request
     * @param  \App\Models\PaymentRecord  $paymentRecord
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRecordRequest $request, PaymentRecord $paymentRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentRecord  $paymentRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentRecord $paymentRecord)
    {
        //
    }
}
