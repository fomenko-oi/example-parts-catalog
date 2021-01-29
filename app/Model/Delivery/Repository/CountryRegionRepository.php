<?php

declare(strict_types=1);

namespace App\Model\Delivery\Repository;

use App\Model\Delivery\Entity\Country\Country;
use App\Model\Delivery\Entity\Country\CountryRegion;
use App\Model\Delivery\Entity\Delivery\DeliveryMethod;
use App\Model\Delivery\Entity\Region\Region;

class CountryRegionRepository
{
    public function all()
    {
        return Country::orderBy('name', 'ASC')->orderBy('name_ru', 'ASC')->get();
    }

    public function getDeliveriesWithCountries()
    {
        return Country::with('regions.country')->get();
    }

    public function getDeliveryCountries(DeliveryMethod $delivery)
    {
        return Country::join('delivery_regions_countries', 'delivery_regions_countries.country_id', '=', 'countries.id')
            ->whereIn('delivery_regions_countries.region_id', $delivery->regions()->select('id')->pluck('id'))
            ->get();
    }

    public function getDeliveryMethodCountry(DeliveryMethod $delivery, int $countryId): Country
    {
        return Country::join('delivery_regions_countries', 'delivery_regions_countries.country_id', '=', 'countries.id')
            ->whereIn('delivery_regions_countries.region_id', $delivery->regions()->select('id')->pluck('id'))
            ->where('countries.id', $countryId)
            ->limit(1)
            ->firstOrFail();
    }

    public function findDeliveryMethodCountry(DeliveryMethod $delivery, int $countryId): ?Country
    {
        return Country::join('delivery_regions_countries', 'delivery_regions_countries.country_id', '=', 'countries.id')
            ->whereIn('delivery_regions_countries.region_id', $delivery->regions()->select('id')->pluck('id'))
            ->where('countries.id', $countryId)
            ->limit(1)
            ->get()
            ->first();
    }

    public function deliveryHasCountry(DeliveryMethod $delivery, int $countryId): bool
    {
        return Country::join('delivery_regions_countries', 'delivery_regions_countries.country_id', '=', 'countries.id')
            ->whereIn('delivery_regions_countries.region_id', $delivery->regions()->select('id')->pluck('id'))
            ->where('countries.id', $countryId)
            ->exists();
    }

    public function getDeliveryRegionById(int $id): Region
    {
        return Region::findOrFail($id);
    }

    public function getById(int $id): CountryRegion
    {
        return CountryRegion::findOrFail($id);
    }
}
