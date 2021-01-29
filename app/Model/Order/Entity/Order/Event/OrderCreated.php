<?php

declare(strict_types=1);

namespace App\Model\Order\Entity\Order\Event;

use App\Model\Order\Entity\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class OrderCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Order
     */
    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
