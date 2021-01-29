<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\UseCase;


use App\Entity\Catalog\Brand;
use App\Entity\Catalog\Model\ModelItem;
use App\Model\Catalog\Category\Repository\ModelRepository;
use App\Model\Catalog\Entity\Model\Model;

class ModelService
{
    /**
     * @var ModelRepository
     */
    private ModelRepository $models;

    public function __construct(ModelRepository $models)
    {
        $this->models = $models;
    }

    public function findByName(Brand $brand, string $name): ?ModelItem
    {
        return $brand->models()->where('name', $name)->first();
    }

    public function create(Brand $brand, Model $model): ModelItem
    {
        /** @var ModelItem $item */
        $item = $brand->models()->create([
            'name' => $model->getName(),
            'group' => $model->getGroup(),
            'slug' => $model->getSlug(),
            'region_id' => $model->getRegionId()
        ]);

        return $item;
    }
}
