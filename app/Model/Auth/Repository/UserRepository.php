<?php

declare(strict_types=1);

namespace App\Model\Auth\Repository;

use App\Model\Auth\Entity\Address\AddressDto;
use App\Model\Auth\Entity\Email;
use App\Model\Auth\Entity\Name;
use App\Model\Auth\Entity\Password;
use App\Model\Auth\Entity\Phone;
use App\Model\Auth\Entity\Role;
use App\Model\Auth\Entity\User;
use App\Model\Delivery\Repository\CountriesRepository;
use App\Model\Delivery\Repository\CountryRegionCityRepository;
use App\Model\Delivery\Repository\CountryRegionRepository;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
{
    /**
     * @var CountriesRepository
     */
    private CountriesRepository $countries;
    /**
     * @var CountryRegionRepository
     */
    private CountryRegionRepository $regions;
    /**
     * @var CountryRegionCityRepository
     */
    private CountryRegionCityRepository $cities;

    public function __construct(CountriesRepository $countries, CountryRegionRepository $regions, CountryRegionCityRepository $cities)
    {
        $this->countries = $countries;
        $this->regions = $regions;
        $this->cities = $cities;
    }

    public function paginate($limit): LengthAwarePaginator
    {
        return User::orderBy('created_at', 'DESC')->paginate($limit);
    }

    public function getById(int $id): User
    {
        return User::findOrFail($id);
    }

    public function hasByEmail(Email $email): bool
    {
        return User::where('email', $email->getValue())->exists();
    }

    public function getByEmail(Email $email): User
    {
        return User::where('email', $email->getValue())->firstOrFail();
    }

    public function updatePassword(User $user, Password $password)
    {
        $user->update(['password' => $password->getValue()]);
    }

    public function update(User $user, Email $email, Phone $phone, Role $role, Name $name, Password $password, ?AddressDto $address = null): User
    {
        return DB::transaction(function() use($user, $email, $role, $name, $password, $address, $phone) {
            $user->update([
                'email' => $email->getValue(),
                'phone' => $phone->getValue(),
                'role' => $role->getValue(),
                'password' => $password->getValue(),
                'name' => $name->getValue()
            ]);

            if ($address) {
                $this->checkAddress($address);
                $user->updateAddress($address);
            }

            return $user;
        });
    }

    public function create(Email $email, Phone $phone, Role $role, Name $name, Password $password, ?AddressDto $address = null): User
    {
        if ($this->hasByEmail($email)) {
            throw new \DomainException('The email is already exist.');
        }

        return DB::transaction(function() use($email, $role, $name, $password, $address, $phone) {
            /** @var User $user */
            $user = User::create([
                'email' => $email->getValue(),
                'phone' => $phone->getValue(),
                'role' => $role->getValue(),
                'password' => $password->getValue(),
                'name' => $name->getValue()
            ]);

            if ($address) {
                $this->checkAddress($address);
                $user->createAddress($address);
            }

            return $user;
        });
    }

    protected function checkAddress(AddressDto $address): void
    {
        $country = $this->countries->getById($address->getCountry());
        $region = $this->regions->getById($address->getRegion());
        $city = $this->cities->getById($address->getCity());

        if (!$region->isPartOf($country)) {
            throw new \DomainException('Region is not belongs to this country.');
        }

        if (!$city->isPartof($region)) {
            throw new \DomainException('City is not belongs to this region.');
        }
    }
}
