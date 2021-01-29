<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\Dto\Attribute;

class Filter
{
    private int $id;
    private string $type;
    private string $name;
    private ?string $default;
    private array $values = [];

    public function __construct(int $id, string $name, string $type, ?string $default = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->default = $default;
    }

    public function addValue($value): self
    {
        $this->values[] = $value;
        return $this;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ?string
     */
    public function getDefault(): ?string
    {
        return $this->default;
    }

    public function valuesCount(): int
    {
        return count($this->values);
    }

    public function hasActiveValue($value): bool
    {
        return request('attributes.' . $this->id) === $value;
    }

    public function getMaxValue(): ?int
    {
        return max($this->values);
    }

    public function withSortedValues(): self
    {
        $clone = clone $this;
        sort($clone->values);
        return $clone;
    }
}
