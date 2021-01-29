<?php

declare(strict_types=1);

namespace App\Service\Catalog\Detali\Price;

use App\Entity\Catalog\Model\Mark\Detail;

class HierarchicPriceModificator implements PriceModificator
{
    private int $globalPercent;

    public function __construct(int $globalPercent)
    {
        $this->globalPercent = $globalPercent;
    }

    // 1. Global site
    // 2. Category
    // 3. Brand
    // 3. Model
    // 4. Mark
    public function modify(Detail $detail): float
    {
        if (($discount = $detail->group->mark->discount) && !is_null($discount->discount)) {
            return $this->modifyPrice($detail->price, $discount->discount);
        }

        if (($discount = $detail->group->mark->model->discount) && !is_null($discount->discount)) {
            return $this->modifyPrice($detail->price, $discount->discount);
        }

        if (($discount = $detail->group->mark->model->brand->discount) && !is_null($discount->discount)) {
            return $this->modifyPrice($detail->price, $discount->discount);
        }

        if (($discount = $detail->group->mark->model->brand->region->category->discount) && !is_null($discount->discount)) {
            return $this->modifyPrice($detail->price, $discount->discount);
        }

        if (($discount = $this->globalPercent) && $discount !== 0) {
            return $this->modifyPrice($detail->price, $discount);
        }

        return $detail->price;
    }

    protected function modifyPrice($price, $discount)
    {
        if ($discount === 0) {
            return $price;
        }
        if ($discount < 0) {
            return $price * (1 + (abs($discount) / 100));
        }
        return $price * (1 - ($discount / 100));
    }
}
