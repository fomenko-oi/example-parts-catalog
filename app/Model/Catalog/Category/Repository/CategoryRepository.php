<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\Repository;

use App\Entity\Catalog\Brand;
use App\Entity\Catalog\Category;
use App\Entity\Catalog\Region;
use App\Model\Catalog\Category\Repository\DTO\CategoryBrandsItem;
use Illuminate\Support\Collection;

class CategoryRepository
{
    public function getById(int $id): Category
    {
        return Category::where('id', $id)->firstOrFail();
    }

    public function getBySlug(string $slug): Category
    {
        return Category::where('slug', $slug)->firstOrFail();
    }

    public function getWithBrandsList(): Collection
    {
        $list = Category::with('brands', 'regions.brands')->get();

        $categories = $list->map(function (Category $category) {
            $item = new CategoryBrandsItem($category);
            $category->brands->each(function (Brand $brand) use ($item) {
                $item->addBrand($brand);
            });
            $category->regions->each(function (Region $region) use ($item) {
                $region->brands->each(function (Brand $brand) use ($item) {
                    $item->addBrand($brand);
                });
            });

            return $item;
        });

        return $categories;
    }
}
