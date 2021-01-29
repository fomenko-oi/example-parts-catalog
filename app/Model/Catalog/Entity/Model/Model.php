<?php

declare(strict_types=1);

namespace App\Model\Catalog\Entity\Model;

class Model
{
    private string $name;
    private array $group;
    private string $slug;
    private int $regionId;

    public function __construct(string $name, string $slug, int $regionId, array $group = [])
    {
        $this->name = $name;
        $this->group = $group;
        $this->slug = $slug;
        $this->regionId = $regionId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getGroup(): array
    {
        return $this->group;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function getRegionId(): int
    {
        return $this->regionId;
    }
}
