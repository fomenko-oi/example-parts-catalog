<?php

declare(strict_types=1);

namespace App\Model\Order\Entity\Customer;

class Address
{
    private int $country;
    private int $region;
    private int $city;
    private string $address;
    private int $postcode;

    public function __construct(int $country, int $region, int $city, string $address, int $postcode)
    {
        $this->country = $country;
        $this->region = $region;
        $this->city = $city;
        $this->address = $address;
        $this->postcode = $postcode;
    }

    /**
     * @return int
     */
    public function getCountry(): int
    {
        return $this->country;
    }

    /**
     * @return int
     */
    public function getRegion(): int
    {
        return $this->region;
    }

    /**
     * @return int
     */
    public function getCity(): int
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getPostcode(): int
    {
        return $this->postcode;
    }
}
