<?php

namespace App\Notifications\User;

use App\Model\Deposit\Entity\Refill\Refill;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderRefillStatusChanged extends Notification
{
    use Queueable;

    /**
     * @var Refill
     */
    public Refill $refill;

    public function __construct(Refill $refill)
    {
        $this->refill = $refill;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $status = __('statuses.refill.' . $this->refill->getStatus()->getValue());

        $builder = (new MailMessage)->line(__('Payment status') . " **#{$this->refill->id}** ". __('changed to') ." **{$status}**.");

        if ($this->refill->getStatus()->isCanceled() && !empty($this->refill->cancel_reason)) {
            $builder->line(__('Rejected by reason') . ": **{$this->refill->cancel_reason}**");
        }

        return $builder->line(__('Thank you') . '!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
