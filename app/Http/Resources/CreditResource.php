<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CreditResource extends JsonResource
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
            'payer' => $this->whenLoaded('payer', PayerResource::make($this->payer)),
            'amount' => $this->amount,
            'description' => $this->description,
            'createdAt' => $this->created_at,
        ];
    }
}
