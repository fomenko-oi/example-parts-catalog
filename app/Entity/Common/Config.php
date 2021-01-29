<?php

declare(strict_types=1);

namespace App\Entity\Common;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Common\Config
 *
 * @property int $id
 * @property string $name
 * @property string $key
 * @property string|null $value
 * @property bool $autoload
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Common\Config autoload()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Common\Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Common\Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Common\Config query()
 * @mixin \Eloquent
 */
class Config extends Model
{
    protected $table = 'configs';
    protected $fillable = ['name', 'key', 'value', 'autoload'];

    public $timestamps = false;

    protected $casts = [
        'autoload' => true
    ];

    public function scopeAutoload($query)
    {
        return $query->where('autoload', true);
    }
}
