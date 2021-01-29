<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\Dto\Attribute;

class AttributesFilterDto
{
    /** @var array Filter[] $filters */
    private array $filters = [];

    public function addFilter(Filter $filter): self
    {
        $this->filters[$filter->getId()] = $filter;
        return $this;
    }

    public function hasFilter(int $id): bool
    {
        return isset($this->filters[$id]);
    }

    /**
     * @return Filter[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    public function filterCount(): int
    {
        return count($this->filters);
    }

    public function findFilterByName(string $name): ?Filter
    {
        foreach ($this->filters as $filter) {
            if (mb_strtolower($filter->getName()) === mb_strtolower($name)) {
                return $filter;
            }
        }
        return null;
    }

    public function hasFilterByName(string $name): bool
    {
        foreach ($this->filters as $filter) {
            if (mb_strtolower($filter->getName()) === mb_strtolower($name)) {
                return true;
            }
        }
        return false;
    }
}
