<?php

namespace App\Http\Resources\User\Order;

use App\Model\Cart\Service\Cart;
use App\Model\Cart\Service\CartItem;
use App\Model\Order\Entity\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Order $order */
        $order = $this;
        $status = $order->getStatus();
        $paymentStatus = $order->getPaymentStatus();

        return [
            'id' => $order->id,
            'items' => OrderDetailResource::collection($order->details),
            'date' => $order->created_at->format('d.m.y'),
            'quantity' => $order->details->count(),
            'status' => [
                'value' => $status->getValue(),
                'name' => __('statuses.order.' . $status->getValue()),
            ],
            'payment_status' => [
                'value' => $paymentStatus->getValue(),
                'name' => __('statuses.payment.' . $paymentStatus->getValue()),
            ],
            'total_price' => [
                'rub' => toRub($order->cost),
                'usd' => toDollarYen($order->cost),
                'yen' => $order->cost,
            ],
            'delivery' => [
                'cost' => [
                    'rub' => toRub($order->delivery_cost),
                    'usd' => toDollarYen($order->delivery_cost),
                    'yen' => $order->delivery_cost,
                ],
                'name' => $order->deliveryMethod->name,
                'name_ru' => $order->deliveryMethod->name_ru,
            ],
            'class' => $order->getPaymentStatus()->isCompleted() ? 'done' : $status->getClass(),
        ];
    }
}
