<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PeriodPaymentPayerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'periodPayment' => PeriodPaymentResource::make($this->whenLoaded('periodPayment')),
            'payer' => PayerResource::make($this->whenLoaded('payer')),
            'amount' => $this->amount,
        ];
    }
}
