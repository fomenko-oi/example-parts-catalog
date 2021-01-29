<?php

declare(strict_types=1);

namespace App\Model\Delivery\Entity\Delivery;

use App\Model\Delivery\Entity\Region\Region;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Delivery\Entity\Delivery\Range
 *
 * @property int $id
 * @property float $from
 * @property float $to
 * @property string $type
 * @property float $price
 * @property int $region_id
 * @property-read \App\Model\Delivery\Entity\Region\Region $region
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Delivery\Range newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Delivery\Range newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Delivery\Range query()
 * @mixin \Eloquent
 */
class Range extends Model
{
    const TYPE_WEIGHT = 'weight';
    const TYPE_ORDER_PRICE = 'order_price';

    protected $table = 'delivery_region_ranges';
    protected $fillable = [
        'from',
        'to',
        'type',
        'price',
        'region_id'
    ];
    public $timestamps = false;

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    public function isByWeight(): bool
    {
        return $this->type === self::TYPE_WEIGHT;
    }

    public function getFromKg(): float
    {
        return $this->from / 1000;
    }

    public function getToKg(): float
    {
        return $this->to / 1000;
    }
}
