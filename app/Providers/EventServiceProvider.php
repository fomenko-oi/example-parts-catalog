<?php

namespace App\Providers;

use App\Listeners\Order\SendUserInvoice;
use App\Listeners\User\DetailRequest\SendAdminDetailRequestNotification;
use App\Listeners\User\Refill\SendAdminRefillBillNotification;
use App\Listeners\User\Refill\SendRefillStatusChangeNotification;
use App\Model\Deposit\Entity\Refill\Event\RefillCanceled;
use App\Model\Deposit\Entity\Refill\Event\RefillCompleted;
use App\Model\Deposit\Entity\Refill\Event\RefillCreated;
use App\Model\Order\Entity\Order\Event\OrderCreated;
use App\Model\Order\Entity\Request\Event\RequestCompleted;
use App\Model\Order\Entity\Request\Event\RequestCreated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderCreated::class => [SendUserInvoice::class],

        // refills
        RefillCreated::class => [SendAdminRefillBillNotification::class],
        RefillCompleted::class => [SendRefillStatusChangeNotification::class],
        RefillCanceled::class => [SendRefillStatusChangeNotification::class],

        // detail requests
        RequestCreated::class => [SendAdminDetailRequestNotification::class],
        RequestCompleted::class => [],
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
