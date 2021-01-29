<?php

use App\Model\Order\Entity\Order\Status;
use App\Model\Order\Entity\Order\PaymentStatus;
use App\Model\Deposit\Entity\Refill\Status as RefillStatus;

return [
    'order' => Status::getStatusesList(),
    'payment' => PaymentStatus::getStatusList(),
    'refill' => RefillStatus::getStatusesList()
];
