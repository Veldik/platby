<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->whenLoaded('paymentRecords', function () {
                return [
                    'paid' => [
                        'amount' => $this->paymentRecords->whereNotNull('paid_at')->sum('amount'),
                        'records' => $this->paymentRecords->whereNotNull('paid_at')->count(),
                    ],
                    'unpaid' => [
                        'amount' => $this->paymentRecords->whereNull('paid_at')->sum('amount'),
                        'records' => $this->paymentRecords->whereNull('paid_at')->count(),
                    ],
                    'total' => [
                        'amount' => $this->paymentRecords->sum('amount'),
                        'records' => $this->paymentRecords->count(),
                    ],
                ];
            }),
            'paymentRecords' => PaymentRecordResource::collection($this->whenLoaded('paymentRecords')),
        ];
    }
}
