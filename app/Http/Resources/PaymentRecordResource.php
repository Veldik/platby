<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'payer' => PayerResource::make($this->whenLoaded('payer')),
            'payment' => PaymentResource::make($this->whenLoaded('payment')),
            'paid_at' => $this->paid_at,
            'qr_code' => $this->getQRCode(),
        ];
    }
}
