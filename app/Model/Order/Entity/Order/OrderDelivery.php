<?php

declare(strict_types=1);

namespace App\Model\Order\Entity\Order;

use Webmozart\Assert\Assert;

class OrderDelivery
{
    protected string $type;
    protected float $price;

    public function __construct(string $type, float $price)
    {
        $this->type = $type;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
