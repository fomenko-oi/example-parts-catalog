<?php

declare(strict_types=1);

namespace App\Model\Catalog\Entity\Detail;

class Detail
{
    /**
     * @var Name
     */
    private Name $name;
    /**
     * @var Quantity
     */
    private Quantity $quantity;
    /**
     * @var Status
     */
    private Status $status;
    /**
     * @var Price
     */
    private Price $price;
    private bool $visible;
    private ?int $groupId;

    public function __construct(Name $name, Quantity $quantity, Status $status, Price $price, bool $visible = true, ?int $groupId = null)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->status = $status;
        $this->price = $price;
        $this->visible = $visible;
        $this->groupId = $groupId;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return Quantity
     */
    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @return int|null
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }
}
