<?php

declare(strict_types=1);

namespace App\Model\Catalog\Entity\Detail;

class Price
{
    private ?int $price;

    public function __construct(?int $price)
    {
        $this->price = $price;
    }

    public function getValue(): ?int
    {
        return $this->price;
    }
}
