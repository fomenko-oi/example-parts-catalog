<?php

declare(strict_types=1);

namespace App\Model\Order\Repository;

use App\Model\Delivery\Entity\Delivery\DeliveryMethod;
use App\Model\Delivery\Entity\Region\Region;

class DeliveryMethodRepository
{
    public function getRegions(DeliveryMethod $delivery)
    {
        return $delivery->regions()->withCount('countries')->get();
    }

    public function getRegion(DeliveryMethod $delivery, int $regionId): Region
    {
        return $delivery->regions()->where('id', $regionId)->firstOrFail();
    }

    public function getById(int $id): DeliveryMethod
    {
        return DeliveryMethod::findOrFail($id);
    }

    public function getMaxSort(): int
    {
        return DeliveryMethod::max('sort') ?? 0;
    }

    public function all()
    {
        return DeliveryMethod::/*withCount(['countries'])->*/orderBy('sort')->get();
    }

    public function allWith($array)
    {
        return DeliveryMethod::with($array)->orderBy('sort')->get();
    }
}
