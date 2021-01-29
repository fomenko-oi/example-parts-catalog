<?php

declare(strict_types=1);

namespace App\Model\Delivery\Entity\Country;

use App\Model\Delivery\Entity\Region\Region;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Delivery\Entity\Country\City
 *
 * @property int $id
 * @property string $name
 * @property int $region_id
 * @property-read \App\Model\Delivery\Entity\Region\Region $region
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Country\City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Country\City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Country\City query()
 * @mixin \Eloquent
 */
class City extends Model
{
    protected $table = 'country_region_cities';
    public $timestamps = false;
    protected $fillable = [
        'name', 'region_id'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function isPartOf(CountryRegion $region): bool
    {
        return $region->id === $this->region_id;
    }
}
