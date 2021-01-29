<?php

namespace App\Listeners\Order;

use App\Model\Auth\Repository\UserRepository;
use App\Model\Order\Entity\Order\Event\OrderCreated;
use App\Notifications\User\OrderInvoiceGenerated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserInvoice
{
    /**
     * @var UserRepository
     */
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function handle(OrderCreated $event)
    {
        $order = $event->order;
        $user = $this->users->getById($order->user_id);

        $user->notify(new OrderInvoiceGenerated($order));
    }
}
