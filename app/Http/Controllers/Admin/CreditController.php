<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CreditResource;
use App\Models\Payer;

class CreditController extends Controller
{
    public function index(Payer $payer)
    {
        return CreditResource::collection($payer->credits->sortByDesc('created_at'));
    }
}
