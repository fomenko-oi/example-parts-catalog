<?php

declare(strict_types=1);

namespace App\Model\Delivery\Command\Delivery;

class CalculateDeliveryCommand
{
    private int $country;
    private float $weight;

    public function __construct(int $country, float $weight)
    {
        $this->country = $country;
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getCountry(): int
    {
        return $this->country;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }
}
