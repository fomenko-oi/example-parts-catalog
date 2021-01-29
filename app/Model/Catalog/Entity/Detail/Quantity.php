<?php

declare(strict_types=1);

namespace App\Model\Catalog\Entity\Detail;

class Quantity
{
    private int $quantity;
    private ?int $useCount;
    private ?float $weight;

    public function __construct(int $quantity, ?int $useCount, ?float $weight)
    {
        $this->quantity = $quantity;
        $this->useCount = $useCount;
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return int|null
     */
    public function getUseCount(): ?int
    {
        return $this->useCount;
    }

    /**
     * @return int|null
     */
    public function getWeight(): ?float
    {
        return $this->weight;
    }
}
