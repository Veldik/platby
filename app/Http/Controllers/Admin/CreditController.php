<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCreditRequest;
use App\Http\Resources\CreditResource;
use App\Models\Payer;

class CreditController extends Controller
{
    public function index(Payer $payer)
    {
        return CreditResource::collection($payer->credits->sortByDesc('created_at'));
    }

    public function store(Payer $payer, StoreCreditRequest $request)
    {
        $validated = $request->validated();

        $payer->credits()->create([
            'amount' => $validated['amount'],
            'description' => $validated['description'],
        ]);

        return response()->json(['status' => 'ok']);
    }
}
