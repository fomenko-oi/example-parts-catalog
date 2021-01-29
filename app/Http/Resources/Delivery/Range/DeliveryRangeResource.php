<?php

namespace App\Http\Resources\Delivery\Range;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryRangeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'price' => $this->price,
        ];
    }
}
