<?php

namespace App\Http\Controllers;

use App\Models\Payer;
use App\Models\Payment;
use App\Models\PaymentRecord;
use App\Models\User;

class StatsController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = [
            'payments' => Payment::count(),
            'payers' => Payer::count(),
            'paid' => [
                'amount' => PaymentRecord::whereNotNull('paid_at')->sum('amount'),
                'records' => PaymentRecord::whereNotNull('paid_at')->count(),
            ],
            'unpaid' => [
                'amount' => PaymentRecord::whereNull('paid_at')->sum('amount'),
                'records' => PaymentRecord::whereNull('paid_at')->count(),
            ],
            'total' => [
                'amount' => PaymentRecord::sum('amount'),
                'records' => PaymentRecord::count(),
            ],
            'users' => User::count(),
        ];

        return response()->json(['data' => $data]);
    }
}
