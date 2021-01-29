<?php

namespace App\Model\Auth\Entity\Address;

use App\Model\Auth\Entity\User;
use App\Model\Delivery\Entity\Country\City;
use App\Model\Delivery\Entity\Country\Country;
use App\Model\Delivery\Entity\Country\CountryRegion;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Auth\Entity\Address\Address
 *
 * @property int $id
 * @property string $country_id
 * @property string|null $region_id
 * @property string $city_id
 * @property string $address
 * @property string $postcode
 * @property bool $main
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Delivery\Entity\Country\City $city
 * @property-read \App\Model\Delivery\Entity\Country\Country $country
 * @property-read \App\Model\Delivery\Entity\Country\CountryRegion|null $region
 * @property-read \App\Model\Auth\Entity\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth\Entity\Address\Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth\Entity\Address\Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Auth\Entity\Address\Address query()
 * @mixin \Eloquent
 */
class Address extends Model
{
    protected $table = 'user_addresses';
    protected $fillable = [
        'user_id', 'country_id', 'region_id', 'city_id', 'address', 'postcode', 'main'
    ];

    protected $casts = [
        'main' => 'boolean',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function region()
    {
        return $this->belongsTo(CountryRegion::class, 'region_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function isMain(): bool
    {
        return $this->main === true;
    }
}
