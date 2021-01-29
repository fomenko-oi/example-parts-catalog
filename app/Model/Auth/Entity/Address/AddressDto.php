<?php

declare(strict_types=1);

namespace App\Model\Auth\Entity\Address;

class AddressDto
{
    private int $country;
    private int $region;
    private int $city;
    private string $address;
    private int $postCode;
    private bool $isMain;

    public function __construct(int $country, int $region, int $city, string $address, int $postCode, bool $isMain = false)
    {
        $this->country = $country;
        $this->region = $region;
        $this->city = $city;
        $this->address = $address;
        $this->postCode = $postCode;
        $this->isMain = $isMain;
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
    public function getPostCode(): int
    {
        return $this->postCode;
    }

    /**
     * @return bool
     */
    public function isMain(): bool
    {
        return $this->isMain;
    }
}
