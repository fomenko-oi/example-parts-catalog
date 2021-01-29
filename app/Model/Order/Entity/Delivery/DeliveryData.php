<?php

declare(strict_types=1);

namespace App\Model\Order\Entity\Delivery;

use App\Model\Delivery\Entity\Country\City;
use App\Model\Delivery\Entity\Country\Country;
use App\Model\Delivery\Entity\Country\CountryRegion;
use App\Model\Delivery\Entity\Region\Region;
use App\Model\Order\Entity\Order;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Order\Entity\Delivery\DeliveryData
 *
 * @property int $id
 * @property int $order_id
 * @property int $index
 * @property string $address
 * @property int|null $country_id
 * @property int|null $region_id
 * @property int|null $city_id
 * @property-read \App\Model\Delivery\Entity\Country\City|null $city
 * @property-read \App\Model\Delivery\Entity\Country\Country|null $country
 * @property-read \App\Model\Order\Entity\Order $order
 * @property-read \App\Model\Delivery\Entity\Country\CountryRegion|null $region
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\Delivery\DeliveryData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\Delivery\DeliveryData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\Delivery\DeliveryData query()
 * @mixin \Eloquent
 */
class DeliveryData extends Model
{
    protected $table = 'order_delivery_data';

    protected $fillable = [
        'order_id', 'index', 'address', 'country_id', 'region_id', 'city_id'
    ];

    public $timestamps = false;

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

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
