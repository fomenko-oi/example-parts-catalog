<?php

declare(strict_types=1);

namespace App\Model\Delivery\Repository;

use App\Model\Delivery\Entity\Country\Country;
use App\Model\Delivery\Entity\Country\CountryRegion;
use App\Model\Delivery\Entity\Delivery\DeliveryMethod;
use App\Model\Delivery\Entity\Region\Region;

class CountriesRepository
{
    public function getById(int $id): Country
    {
        return Country::findOrFail($id);
    }

    public function getRegionCities(CountryRegion $region)
    {
        return $region->cities()->orderBy('name', 'asc')->get();
    }

    public function getRegions(Country $country)
    {
        return $country->regions()->withCount('cities')->orderBy('name')->get();
    }

    public function delete(Country $country): void
    {
        $country->delete();
    }

    public function getForDeliveryMethod(DeliveryMethod $deliveryMethod, ?Region $region = null)
    {
        $regions = $deliveryMethod->regions()->with('countries')->get();
        $ids = [];

        /** @var Region $item */
        foreach ($regions as $item) {
            if ($region && $region->id === $item->id) {
                continue;
            }
            $ids = array_unique(array_merge($ids, $item->countries->pluck('id')->toArray()));
        }

        return Country::orderBy('name', 'ASC')->whereNotIn('id', $ids)->get();
    }

    public function all()
    {
        return Country::orderBy('name', 'ASC')->withCount('regions')->get();
    }
}
