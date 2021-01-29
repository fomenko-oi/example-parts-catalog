<?php

declare(strict_types=1);

namespace App\Model\Catalog\Entity\Category\Attribute;

use Webmozart\Assert\Assert;

class Value
{
    private string $type;
    private ?string $default;
    private bool $required;
    private array $variants;

    public function __construct(string $type, string $default = null, bool $required = false, array $variants = [])
    {
        Assert::oneOf($type, array_keys(\App\Entity\Catalog\Attribute::getTypesList()));

        $this->type = $type;
        $this->default = $default;
        $this->required = $required;
        $this->variants = $variants;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getDefault(): ?string
    {
        return $this->default;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @return array
     */
    public function getVariants(): array
    {
        return $this->variants;
    }
}
