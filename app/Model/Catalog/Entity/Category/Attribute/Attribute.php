<?php

declare(strict_types=1);

namespace App\Model\Catalog\Entity\Category\Attribute;

class Attribute
{
    /**
     * @var Name
     */
    private Name $name;
    /**
     * @var Value
     */
    private Value $value;
    private int $sort;
    private bool $filterable;

    public function __construct(Name $name, Value $value, int $sort = 0, bool $filterable = false)
    {
        $this->name = $name;
        $this->value = $value;
        $this->sort = $sort;
        $this->filterable = $filterable;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return Value
     */
    public function getValue(): Value
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @return bool
     */
    public function isFilterable(): bool
    {
        return $this->filterable;
    }
}
