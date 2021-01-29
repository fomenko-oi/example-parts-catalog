<?php

declare(strict_types=1);

namespace App\Model\Catalog\UseCase;

use App\Entity\Catalog\Brand;
use App\Entity\Catalog\Category;
use App\Entity\Catalog\Model\Mark;
use App\Entity\Catalog\Model\ModelItem;
use App\Entity\Catalog\Region;
use App\Model\Catalog\Category\Repository\ModelRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ModelItemService
{
    /**
     * @var ModelRepository
     */
    private ModelRepository $modelItems;

    public function __construct(ModelRepository $modelItems)
    {
        $this->modelItems = $modelItems;
    }

    public function getMarks(ModelItem $model, int $limit, array $request = []): LengthAwarePaginator
    {
        $q = $model->marks()->with(['values']);

        if ($request && isset($request['attributes']) && ($attributes = $request['attributes'])) {
            foreach($attributes as $attributeId => $value) {
                $q->whereHas('values', function($q) use($value) {
                    $q->where('value', $value);
                });
            }
        }

        return $q->paginate($limit);
    }

    public function getGroupedByName(Category $category, Region $region, Brand $brand)
    {
        return $this->modelItems->find($category, $region, $brand)->groupBy(function (ModelItem $model) {
            return substr($model->name, 0, 1);
        })->sortKeys(SORT_NATURAL);
    }
}
