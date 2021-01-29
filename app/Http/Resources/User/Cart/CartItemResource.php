<?php

namespace App\Http\Resources\User\Cart;

use App\Entity\Catalog\Model\Mark\Detail;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Detail $detail */
        $detail = $this->getDetail();

        return [
            'id' => $this->getId(),
            'quantity' => $this->getQuantity(),
            'price_yen' => $detail->getPrice(),
            'price_rub' => toRub($detail->getPrice()),
            'price_usd' => toDollarYen($detail->getPrice()),
            'detail' => new CartDetailResource($detail)
        ];
    }
}
