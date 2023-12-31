<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PeriodPaymentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'displayTitle' => $this->displayTitle(),
            'description' => $this->description,
            'displayDescription' => $this->displayDescription(),
            'cronExpression' => $this->cron_expression,
            'lastRun' => $this->last_run,
            'nextRun' => $this->nextRun(),
            'periodPayers' => PeriodPaymentPayerResource::collection($this->whenLoaded('periodPayers')),
        ];
    }
}
