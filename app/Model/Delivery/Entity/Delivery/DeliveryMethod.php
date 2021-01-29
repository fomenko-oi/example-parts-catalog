<?php

declare(strict_types=1);

namespace App\Model\Delivery\Entity\Delivery;

use App\Model\Delivery\Entity\Country\Country;
use App\Model\Delivery\Entity\Region\Region;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Delivery\Entity\Delivery\DeliveryMethod
 *
 * @property int $id
 * @property string $name
 * @property float|null $min_weight
 * @property float|null $max_weight
 * @property int $sort
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Delivery\Entity\Region\Region[] $regions
 * @property-read int|null $regions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Delivery\DeliveryMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Delivery\DeliveryMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Delivery\DeliveryMethod query()
 * @mixin \Eloquent
 * @property int $cost
 * @property string|null $name_ru
 * @property string|null $key
 */
class DeliveryMethod extends Model
{
    protected $table = 'delivery_methods';

    protected $fillable = [
        'name',
        'name_ru',
        'min_weight',
        'max_weight',
        'sort',
        'key'
    ];

    public $timestamps = false;

    public function regions()
    {
        return $this->hasMany(Region::class, 'delivery_method_id', 'id');
    }

    public function isAvailableForWeight($weight): bool
    {
        return (!$this->min_weight || $this->min_weight <= $weight)
            && (!$this->max_weight || $weight <= $this->max_weight);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}
