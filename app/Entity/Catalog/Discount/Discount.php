<?php

declare(strict_types=1);

namespace App\Entity\Catalog\Discount;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Catalog\Discount\Discount
 *
 * @property int $id
 * @property int $discount
 * @property int $entity_id
 * @property string $entity_type
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $entity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Discount\Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Discount\Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Discount\Discount query()
 * @mixin \Eloquent
 */
class Discount extends Model
{
    protected $table = 'catalog_discounts';

    protected $fillable = ['discount', 'entity_id', 'entity_type'];

    public $timestamps = false;

    public function entity()
    {
        return $this->morphTo();
    }
}
