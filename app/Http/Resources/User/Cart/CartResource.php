<?php

namespace App\Http\Resources\User\Cart;

use App\Model\Cart\Service\Cart;
use App\Model\Cart\Service\CartItem;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Cart $cart */
        $cart = $this;

        return [
            'items' => array_map(function(CartItem $item) {
                return [
                    'id' => $item->getId(),
                    'quantity' => $item->getQuantity(),
                    'detail' => $item->getDetail()->toArray(),
                    'weight' => $item->getWeight(),
                    'price_yen' => $item->getPrice(),
                    'price_rub' => toRub($item->getPrice()),
                    'price_usd' => toDollarYen($item->getPrice()),
                ];
            }, $cart->getItems()),
            'cost' => [
                'total_rub' => toRub($cart->getCost()->getTotal()),
                'total_usd' => toDollarYen($cart->getCost()->getTotal()),
                'total_yen' => $cart->getCost()->getTotal(),
            ],
            'weight' => $cart->getWeight(),
            'amount' => $cart->getAmount(),
        ];
    }
}
