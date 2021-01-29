<?php

declare(strict_types=1);

namespace App\Entity\Catalog;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Catalog\Attribute
 *
 * @property int $id
 * @property string $name
 * @property string $label_ru
 * @property string $type
 * @property string $label
 * @property string|null $default
 * @property bool $required
 * @property array|null $variants
 * @property int $sort
 * @property int|null $category_id
 * @property int|null $brand_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $filterable
 * @property string|null $name_ru
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Attribute query()
 * @mixin \Eloquent
 * @property string $lang
 */
class Attribute extends Model
{
    const LANG_RU = 'ru';
    const LANG_EN = 'en';

    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'integer';
    const TYPE_FLOAT = 'float';
    const TYPE_RANGE = 'range';
    const TYPE_SELECT = 'select';
    const TYPE_GREATER = 'greater';
    const TYPE_LESS = 'less';

    protected $table = 'catalog_attributes';

    protected $fillable = ['name', 'type', 'required', 'label', 'label_ru', 'default', 'variants', 'sort', 'category_id', 'brand_id', 'filterable', 'lang'];

    protected $casts = [
        'variants' => 'array',
        'required' => 'boolean',
        'filterable' => 'boolean',
    ];

    public function isString(): bool
    {
        return $this->type === self::TYPE_STRING;
    }

    public function isInteger(): bool
    {
        return $this->type === self::TYPE_INTEGER;
    }

    public function isFloat(): bool
    {
        return $this->type === self::TYPE_FLOAT;
    }

    public function isNumber(): bool
    {
        return $this->isInteger() || $this->isFloat();
    }

    public function isRange(): bool
    {
        return $this->type === self::TYPE_RANGE;
    }

    public function isGreater(): bool
    {
        return $this->type === self::TYPE_GREATER;
    }

    public function isLess(): bool
    {
        return $this->type === self::TYPE_LESS;
    }

    public function isSelect(): bool
    {
        return $this->type === self::TYPE_SELECT && \count($this->variants) > 0;
    }

    public function getType()
    {
        return self::getTypesList()[$this->type];
    }

    public function isRequired(): bool
    {
        return $this->required === true;
    }

    public static function getTypesList(): array
    {
        return [
            self::TYPE_STRING => 'String',
            self::TYPE_INTEGER => 'Integer',
            self::TYPE_FLOAT => 'Float',
            self::TYPE_SELECT => 'Select',
            //self::TYPE_RANGE => 'Range',
            //self::TYPE_GREATER => 'Greater than',
            //self::TYPE_LESS => 'Less than',
        ];
    }
}
