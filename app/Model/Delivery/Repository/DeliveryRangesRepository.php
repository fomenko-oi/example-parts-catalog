<?php

declare(strict_types=1);

namespace App\Model\Delivery\Repository;

use App\Model\Delivery\Entity\Delivery\Range;
use App\Model\Delivery\Entity\Region\Region;

class DeliveryRangesRepository
{
    public function findRangeByWeight(Region $region, float $weight): ?Range
    {
        return $region->ranges()
            ->where('from', '<=', $weight)
            ->where('to', '>', $weight)
            ->where('type', Range::TYPE_WEIGHT)
            ->first();
    }

    public function getRangeByWeight(Region $region, float $weight): Range
    {
        /** @var Range $range */
        $range = $region->ranges()
            ->where('from', '<=', $weight)
            ->where('to', '>', $weight)
            ->where('type', Range::TYPE_WEIGHT)
            ->firstOrFail();

        return $range;
    }
}
