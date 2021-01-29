<?php

declare(strict_types=1);

namespace App\Model\Order\Entity\Customer;

use App\Model\Order\Entity\Order\PaymentType;
use Webmozart\Assert\Assert;

class Payment
{
    private string $type;

    public function __construct(string $type)
    {
        Assert::oneOf($type, array_keys(PaymentType::getTypesList()));
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
