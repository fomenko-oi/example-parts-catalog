<?php

namespace App\Http\Resources\User\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_ru' => $this->name_ru,
            'cost' => $this->cost,
            'min_weight' => $this->min_weight,
            'max_weight' => $this->max_weight,
        ];
    }
}
