<?php

namespace App\Http\Resources\User\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class CartDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'quantity' => $this->quantity,
            'weight' => $this->weight,
            'price_yen' => $this->price,
            'price_rub' => toRub($this->price),
            'price_usd' => toDollarYen($this->price),
        ];
    }
}
