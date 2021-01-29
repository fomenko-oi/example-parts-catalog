<?php

declare(strict_types=1);

namespace App\Model\Catalog\Entity\Mark;

class Mark
{
    private string $name;
    private string $sku;
    private ?string $image;

    public function __construct(string $name, string $sku, ?string $image = null)
    {
        $this->name = $name;
        $this->sku = $sku;
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }
}
