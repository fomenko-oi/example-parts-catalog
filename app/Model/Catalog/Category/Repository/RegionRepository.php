<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\Repository;

use App\Entity\Catalog\Category;
use App\Entity\Catalog\Region;

class RegionRepository
{
    public function getById(int $id): Region
    {
        return Region::where('id', $id)->firstOrFail();
    }

    /**
     * @param Category $category
     * @param string $slug
     * @return Region|null
     */
    public function findForCategory(Category $category, string $slug): ?Region
    {
        /** @var Region $region */
        $region = $category->regions()->where('slug', $slug)->first();
        return $region;
    }

    /**
     * @param Category $category
     * @param string $slug
     * @return Region
     */
    public function getForCategory(Category $category, string $slug): Region
    {
        /** @var Region $region */
        $region = $category->regions()->where('slug', $slug)->firstOrFail();

        return $region;
    }
}
