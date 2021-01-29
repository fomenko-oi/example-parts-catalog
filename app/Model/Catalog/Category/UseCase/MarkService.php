<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\UseCase;

use App\Entity\Catalog\Model\Mark;
use App\Entity\Catalog\Model\ModelItem;
use App\Model\Catalog\Entity\Mark\Mark as MarkItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MarkService
{
    public function create(ModelItem $model, MarkItem $mark): Mark
    {
        /** @var Mark $item */
        $item = $model->marks()->create([
            'name' => $mark->getName(),
            'image' => $mark->getImage(),
            'sku' => $mark->getSku(),
        ]);

        return $item;
    }

    public function getGroups(Mark $mark, $limit = 20): LengthAwarePaginator
    {
        return $mark->groups()->paginate($limit);
    }

    public function getSubjects()
    {
        return Mark\Group::distinct()->select('subject')->get()->pluck('subject')->toArray();
    }
}
