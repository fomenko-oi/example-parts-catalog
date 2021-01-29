<?php

declare(strict_types=1);

namespace App\Model\Delivery\Entity\Region;

use App\Model\Delivery\Entity\Country\Country;
use App\Model\Delivery\Entity\Delivery\DeliveryMethod;
use App\Model\Delivery\Entity\Delivery\Range;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Delivery\Entity\Region\Region
 *
 * @property int $id
 * @property int $delivery_method_id
 * @property string $name
 * @property string|null $name_ru
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Delivery\Entity\Country\Country[] $countries
 * @property-read int|null $countries_count
 * @property-read \App\Model\Delivery\Entity\Delivery\DeliveryMethod $delivery
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Delivery\Entity\Delivery\Range[] $ranges
 * @property-read int|null $ranges_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Region\Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Region\Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Region\Region query()
 * @mixin \Eloquent
 */
class Region extends Model
{
    protected $table = 'delivery_regions';
    protected $fillable = ['name', 'name_ru', 'delivery_method_id'];
    public $timestamps = false;

    public function delivery()
    {
        return $this->belongsTo(DeliveryMethod::class, 'delivery_method_id', 'id');
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'delivery_regions_countries', 'region_id', 'country_id');
    }

    public function ranges()
    {
        return $this->hasMany(Range::class, 'region_id', 'id');
    }
}
