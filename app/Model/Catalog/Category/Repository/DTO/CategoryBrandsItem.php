<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\Repository\DTO;

use App\Entity\Catalog\Brand;
use App\Entity\Catalog\Category;

class CategoryBrandsItem
{
    public Category $category;
    public array $brands = [];

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function addBrand(Brand $brand): self
    {
        $this->brands[] = $brand;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @return array
     */
    public function getBrands(): array
    {
        return $this->brands;
    }
}
