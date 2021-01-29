<?php

use App\Model\Order\Entity\Order\Status;
use App\Model\Order\Entity\Order\PaymentStatus;
use App\Model\Deposit\Entity\Refill\Status as RefillStatus;

return [
    'order' => [
        Status::NEW => 'Новый',
        Status::COMPLETED => 'Выполнен',
        Status::DELIVERING => 'Доставлен',
        Status::CANCELED => 'Отменён',
    ],
    'payment' => [
        PaymentStatus::WAIT => 'В ожидании',
        PaymentStatus::COMPLETED => 'Выполнен',
        PaymentStatus::CANCELED => 'Отменён',
    ],
    'refill' => [
        RefillStatus::NEW => 'Новый',
        RefillStatus::COMPLETED => 'Завершен',
        RefillStatus::CANCELED => 'Отменён',
    ]
];
