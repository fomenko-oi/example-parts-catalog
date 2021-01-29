<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\UseCase;

use App\Entity\Catalog\Region;
use App\Model\Catalog\Category\Repository\BrandRepository;
use App\Model\Catalog\Entity\Brand\Brand as BrandItem;
use App\Entity\Catalog\Brand;

class BrandService
{
    /**
     * @var BrandRepository
     */
    private BrandRepository $brands;

    public function __construct(BrandRepository $brands)
    {
        $this->brands = $brands;
    }

    public function create(Region $region, BrandItem $brand): Brand
    {
        /** @var Brand $item */
        $item = $region->brands()->create([
            'name' => $brand->getName(),
            'slug' => $brand->getSlug(),
            'image' => $brand->getImage()
        ]);

        return $item;
    }
}
