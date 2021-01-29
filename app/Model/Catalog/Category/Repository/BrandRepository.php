<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\Repository;

use App\Entity\Catalog\Brand;
use App\Entity\Catalog\Category;
use App\Entity\Catalog\Region;

class BrandRepository
{
    public function getById(int $id): Brand
    {
        return Brand::where('id', $id)->firstOrFail();
    }

    public function existsBySlug(string $slug, ?int $region = null): bool
    {
        $q = Brand::where('slug', $slug);
        if ($region) {
            $q->where('region_id', $region);
        }
        return $q->exists();
    }

    public function findForRegion(Region $region)
    {
        return Brand::where('region_id', $region->id)->get();
    }
}
