<?php

declare(strict_types=1);

namespace App\Model\Catalog\Entity\Brand;

class Brand
{
    private string $name;
    private string $slug;
    private ?string $image;

    public function __construct(string $name, string $slug, ?string $image = null)
    {
        $this->name = $name;
        $this->slug = $slug;
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
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }
}
