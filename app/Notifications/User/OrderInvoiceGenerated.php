<?php

namespace App\Notifications\User;

use App\Model\Order\Entity\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderInvoiceGenerated extends Notification
{
    use Queueable;

    /**
     * @var Order
     */
    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line(__('You placed an order on the site.'))
            ->action(__('Open invoice'), url(route('cabinet.orders.pay', $this->order)))
            ->line(__('Thank you') . '!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
