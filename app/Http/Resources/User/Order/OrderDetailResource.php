<?php

namespace App\Http\Resources\User\Order;

use App\Model\Order\Entity\OrderItem;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var OrderItem $item */
        $item = $this;

        return [
            'id' => $item->detail_id,
            'name' => $item->detail_name,
            'sku' => $item->detail_code,
            'quantity' => $item->quantity,
            'price' => [
                'yen' => $item->price,
                'rub' => toRub($item->price),
                'usd' => toDollarYen($item->price),
            ],
        ];
    }
}
