<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\Repository;

use App\Entity\Catalog\Brand;
use App\Entity\Catalog\Category;
use App\Entity\Catalog\Model\ModelItem;
use App\Entity\Catalog\Region;

class ModelRepository
{
    public function create(Brand $brand, Region $region, string $name, string $slug, array $groups = []): ModelItem
    {
        /** @var ModelItem $model */
        $model = $brand->models()->create([
            'region_id' => $region->id,
            'name' => $name,
            'slug' => $slug,
            'group' => $groups,
        ]);

        return $model;
    }

    public function getById(int $id): ModelItem
    {
        return ModelItem::where('id', $id)->firstOrFail();
    }

    public function find(Category $category, Region $region, Brand $brand)
    {
        return $brand->models()->where('region_id', '=', $region->id)->get();
    }
}
