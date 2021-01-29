<?php

declare(strict_types=1);

namespace App\Entity\Catalog\Model\Mark;

use App\Entity\Catalog\Model\Mark;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Catalog\Model\Mark\Detail
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $sku
 * @property int|null $quantity
 * @property int|null $use_count
 * @property float|null $weight
 * @property float|null $price
 * @property string $status
 * @property bool $visible
 * @property int $group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $name_en
 * @property string|null $name_ru
 * @property-read \App\Entity\Catalog\Model\Mark\Group $group
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Model\Mark\Detail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Model\Mark\Detail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Model\Mark\Detail query()
 * @mixin \Eloquent
 */
class Detail extends Model
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DISCONTINUED = 'discontinued';
    const STATUS_BY_REQUEST = 'request';
    const STATUS_EXCHANGE = 'exchange';

    protected $table = 'catalog_mark_details';

    protected $fillable = [
        'name', 'name_en', 'name_ru', 'description', 'sku', 'use_count', 'quantity', 'weight', 'price', 'status', 'visible', 'group_id'
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    protected $with = ['group.mark.discount'/*, 'group.mark.model.discount', 'group.mark.model.region.discount', 'group.mark.model.brand.discount'*/];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function getPrice(): float
    {
        return price_coefficient_converter($this);
    }

    public function getWeight(): Weight
    {
        return new Weight($this->weight, Weight::TYPE_KG);
    }

    public function canBeCheckout(int $quantity)
    {
        return $this->quantity >= $quantity;
    }

    public function checkout($quantity): void
    {
        if ($quantity > $this->quantity) {
            throw new \DomainException('Only ' . $this->quantity . ' items are available.');
        }
        $this->setQuantity($this->quantity - $quantity);
    }

    public function setQuantity($quantity): void
    {
        if ($this->quantity == 0 && $quantity > 0) {
            //$this->recordEvent(new ProductAppearedInStock($this));
        }
        $this->update(['quantity' => $quantity]);
    }

    public function hasPrice(): bool
    {
        return !empty($this->price);
    }

    public function hasQuantity(): bool
    {
        return !empty($this->quantity);
    }

    public function hasUseCount(): bool
    {
        return !empty($this->use_count);
    }

    public function hasWeight(): bool
    {
        return !empty($this->weight) || (floor($this->weight) != $this->weight);
    }

    public function isVisible(): bool
    {
        return $this->getOriginal('visible') === true;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isByRequest(): bool
    {
        return $this->status === self::STATUS_BY_REQUEST;
    }

    public function isDiscontinued(): bool
    {
        return $this->status === self::STATUS_DISCONTINUED;
    }

    public function isExchange(): bool
    {
        return $this->status === self::STATUS_EXCHANGE;
    }

    public function getStatus(): string
    {
        return self::getStatusesList()[$this->status] ?? '';
    }

    public function newEloquentBuilder($query): DetailQueryBuilder
    {
        return new DetailQueryBuilder($query);
    }

    public static function getStatusesList(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_BY_REQUEST => 'By request',
            self::STATUS_DISCONTINUED => 'Discontinued',
            self::STATUS_EXCHANGE => 'Replacement',
        ];
    }
}
