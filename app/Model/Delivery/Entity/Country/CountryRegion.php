<?php

declare(strict_types=1);

namespace App\Model\Delivery\Entity\Country;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Delivery\Entity\Country\CountryRegion
 *
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Delivery\Entity\Country\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \App\Model\Delivery\Entity\Country\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Country\CountryRegion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Country\CountryRegion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Country\CountryRegion query()
 * @mixin \Eloquent
 */
class CountryRegion extends Model
{
    protected $table = 'country_regions';
    public $timestamps = false;
    protected $fillable = [
        'name', 'country_id'
    ];

    public function cities()
    {
        return $this->hasMany(City::class, 'region_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function isPartOf(Country $country): bool
    {
        return $country->id === $this->country_id;
    }
}
