<?php

declare(strict_types=1);

namespace App\Model\Cart\Service;

use App\Entity\Catalog\Model\Mark\Detail;

class CartItem
{
    /**
     * @var Detail
     */
    private Detail $detail;
    private int $quantity;

    public function __construct(Detail $detail, int $quantity)
    {
        if (!$detail->canBeCheckout($quantity)) {
            throw new \DomainException('Quantity is too big.');
        }
        $this->detail = $detail;
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->detail->id;
    }

    public function getDetail(): Detail
    {
        return $this->detail;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): float
    {
        return $this->detail->getPrice();
    }

    public function getWeight(): float
    {
        return $this->detail->weight * $this->quantity;
    }

    public function getCost(): float
    {
        return $this->getPrice() * $this->quantity;
    }

    public function plus($quantity): self
    {
        return new static($this->detail, $this->quantity + $quantity);
    }

    public function changeQuantity($quantity): self
    {
        return new static($this->detail, $quantity);
    }
}
