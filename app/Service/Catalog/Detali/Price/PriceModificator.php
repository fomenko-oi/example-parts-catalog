<?php

declare(strict_types=1);

namespace App\Service\Catalog\Detali\Price;

use App\Entity\Catalog\Model\Mark\Detail;

interface PriceModificator
{
    public function modify(Detail $detail): float;
}
