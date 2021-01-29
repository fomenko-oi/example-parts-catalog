<?php

declare(strict_types=1);

namespace App\Service\Catalog\Detali\Price;

use App\Entity\Catalog\Model\Mark\Detail;

class NoActionPriceModificator implements PriceModificator
{
    public function modify(Detail $detail): float
    {
        return $detail->price;
    }
}
