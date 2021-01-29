<?php

declare(strict_types=1);

namespace App\Model\Catalog\Dto\Detail;

class SearchDto
{
    public ?string $title = '';
    public ?string $description = '';
    public ?string $sku = '';
    public array $attributes = [];

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $value
     */
    public function setDescription(?string $value): self
    {
        $this->description = $value;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @param string|null $sku
     */
    public function setSku(?string $sku): self
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function hasAttributes(): bool
    {
        return count($this->attributes) > 0;
    }
}
