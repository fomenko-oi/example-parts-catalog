<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\Repository;

use App\Entity\Catalog\Model\Mark;
use App\Entity\Catalog\Model\Mark\Detail;
use App\Model\Catalog\Dto\Detail\SearchDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class DetailRepository
{
    public function findByMarkId(int $markId)
    {
        /*$mark = Mark::findOrFail($markId);
        return Detail::whereIn('group_id', $mark->groups()->select('id')->pluck('id'))->get();*/

        return Detail::whereHas('group', function(Builder $q) use($markId) {
            return $q->where('mark_id', $markId);
        })->get();
    }

    public function search(SearchDto $request, $limit): LengthAwarePaginator
    {
        $q = Detail::orderBy('created_at', 'DESC')->groupBy('sku');

        if ($title = $request->title) {
            $q->orWhere('name', 'LIKE', "%{$title}%");
        }
        if ($description = $request->description) {
            $q->orWhere('description', 'LIKE', "%{$description}%");
        }
        if ($sku = $request->sku) {
            $q->orWhere('sku', 'LIKE', "%{$sku}%");
        }
        if ($attributes = $request->attributes) {
            foreach($attributes as $attributeId => $value) {
                $q->whereHas('values', function($q) use($value) {
                    $q->where('value', $value);
                });
            }
        }

        return $q->paginate($limit);
    }

    public function getById(int $id): Detail
    {
        return Detail::where('id', $id)->firstOrFail();
    }

    public function delete(Detail $detail)
    {
        $detail->delete();
    }
}
