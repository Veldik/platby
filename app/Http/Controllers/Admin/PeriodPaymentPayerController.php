<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodPaymentPayer;

class PeriodPaymentPayerController extends Controller
{
    public function destroy(PeriodPaymentPayer $periodPaymentPayer)
    {
        $periodPaymentPayer->delete();

        return response()->json(['status' => 'ok']);

    }
}
