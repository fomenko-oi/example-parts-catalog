<?php

declare(strict_types=1);

namespace App\Model\Auth\Entity;

use App\Model\Auth\Entity\Address\Address;
use App\Model\Auth\Entity\Address\AddressDto;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Model\Auth\Entity\User
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Auth\Entity\Address\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \App\Model\Auth\Entity\Address\Address|null $mainAddress
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth\Entity\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth\Entity\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth\Entity\User query()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function mainAddress()
    {
        return $this->hasOne(Address::class)->where('main', true);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function createAddress(AddressDto $address): Address
    {
        /** @var Address $item */
        $item = $this->addresses()->create([
            'country_id' => $address->getCountry(),
            'region_id' => $address->getRegion(),
            'city_id' => $address->getCity(),
            'address' => $address->getAddress(),
            'postcode' => $address->getPostCode(),
            'main' => $address->isMain()
        ]);

        return $item;
    }

    public function updateAddress(AddressDto $address): void
    {
        $this->mainAddress->update([
            'country_id' => $address->getCountry(),
            'region_id' => $address->getRegion(),
            'city_id' => $address->getCity(),
            'address' => $address->getAddress(),
            'postcode' => $address->getPostCode(),
            'main' => $address->isMain()
        ]);
    }

    public function getRole(): Role
    {
        return new Role($this->role);
    }
}
