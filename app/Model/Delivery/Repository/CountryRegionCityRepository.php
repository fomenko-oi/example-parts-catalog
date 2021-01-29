<?php

declare(strict_types=1);

namespace App\Model\Delivery\Repository;

use App\Model\Delivery\Entity\Country\City;

class CountryRegionCityRepository
{
    public function getById(int $id): City
    {
        return City::findOrFail($id);
    }
}
