<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Credit;
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
            'credits' => [
                'amount' => [
                    'total' => Credit::sum('amount'),
                    'deposit' => Credit::where('amount', '>', 0)->sum('amount'),
                    'withdraw' => Credit::where('amount', '<', 0)->sum('amount'),
                ],
                'records' => [
                    'total' => Credit::count(),
                    'deposit' => Credit::where('amount', '>', 0)->count(),
                    'withdraw' => Credit::where('amount', '<', 0)->count(),
                ]
            ],
            'users' => [
                'total' => User::count(),
                'admins' => User::where('role', 'admin')->count(),
                'users' => User::where('role', 'user')->count(),
            ]
        ];

        return response()->json(['data' => $data]);
    }
}
