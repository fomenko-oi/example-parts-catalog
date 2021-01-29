<?php

declare(strict_types=1);

namespace App\Model\Delivery\Entity\Country;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Delivery\Entity\Country\Country
 *
 * @property int $id
 * @property string $name
 * @property string|null $name_ru
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Delivery\Entity\Country\CountryRegion[] $regions
 * @property-read int|null $regions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Country\Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Country\Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Delivery\Entity\Country\Country query()
 * @mixin \Eloquent
 */
class Country extends Model
{
    protected $table = 'countries';
    public $timestamps = false;

    protected $fillable = ['name', 'name_ru'];

    public function regions()
    {
        return $this->hasMany(CountryRegion::class);
    }
}
