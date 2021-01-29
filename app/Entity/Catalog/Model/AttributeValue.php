<?php

declare(strict_types=1);

namespace App\Entity\Catalog\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Catalog\Model\AttributeValue
 *
 * @property int $id
 * @property int $attribute_id
 * @property int $mark_id
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Model\AttributeValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Model\AttributeValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Model\AttributeValue query()
 * @mixin \Eloquent
 */
class AttributeValue extends Model
{
    protected $table = 'catalog_marks_values';

    public $timestamps = false;

    protected $fillable = ['attribute_id', 'value'];
}
