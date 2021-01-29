<?php

declare(strict_types=1);

namespace App\Model\Delivery\UseCase;

use App\Model\Delivery\Command\Delivery\CalculateDeliveryCommand;
use App\Model\Delivery\Entity\Country\Country;
use App\Model\Delivery\Entity\Delivery\DeliveryMethod;
use App\Model\Delivery\Repository\CountriesRepository;
use App\Model\Delivery\Repository\CountryRegionRepository;
use App\Model\Delivery\Repository\DeliveryRangesRepository;

class CountryService
{
    /**
     * @var CountriesRepository
     */
    private CountriesRepository $countries;
    /**
     * @var CountryRegionRepository
     */
    private CountryRegionRepository $countryDelivery;
    /**
     * @var CountryRegionRepository
     */
    private CountryRegionRepository $deliveryRegion;
    /**
     * @var DeliveryRangesRepository
     */
    private DeliveryRangesRepository $deliveryRanges;

    public function __construct(CountriesRepository $countries, CountryRegionRepository $countryDelivery, DeliveryRangesRepository $deliveryRanges)
    {
        $this->countries = $countries;
        $this->countryDelivery = $countryDelivery;
        $this->deliveryRanges = $deliveryRanges;
    }

    public function calculateDelivery(DeliveryMethod $deliveryMethod, CalculateDeliveryCommand $command): float
    {
        $country = $this->countryDelivery->findDeliveryMethodCountry($deliveryMethod, $command->getCountry());

        if (!$country) {
            throw new \DomainException('This delivery doesn\'t work in your country.');
        }

        if ($command->getWeight() > $deliveryMethod->max_weight) {
            throw new \DomainException('Max weight in this system ' . $deliveryMethod->max_weight .', you have ' . $command->getWeight() .'.');
        }

        $region = $this->countryDelivery->getDeliveryRegionById($country->region_id);

        $range = $this->deliveryRanges->findRangeByWeight($region, (int)($command->getWeight() * 1000));
        if(!$range) {
            throw new \DomainException('Unable to calculate delivery price by your weight.');
        }

        return $range->price;
    }
}
