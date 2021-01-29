<?php

declare(strict_types=1);

namespace App\Entity\Catalog;

use App\Entity\Catalog\Discount\Discount;
use App\Entity\Catalog\Model\ModelItem;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Catalog\Brand
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $image
 * @property int|null $region_id
 * @property int|null $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $name_ru
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Catalog\Attribute[] $brandAttributes
 * @property-read int|null $brand_attributes_count
 * @property-read \App\Entity\Catalog\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Catalog\Attribute[] $categoryAttributes
 * @property-read int|null $category_attributes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Catalog\Model\ModelItem[] $models
 * @property-read int|null $models_count
 * @property-read \App\Entity\Catalog\Region|null $region
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Brand findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Brand query()
 * @mixin \Eloquent
 * @property-read \App\Entity\Catalog\Discount\Discount|null $discount
 */
class Brand extends Model
{
    use Sluggable;

    protected $table = 'catalog_brands';

    protected $fillable = [
        'name', 'name_ru', 'slug', 'image', 'region_id', 'category_id'
    ];

    protected $with = ['discount'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function discount()
    {
        return $this->morphOne(Discount::class, 'entity');
    }

    public function models()
    {
        return $this->hasMany(ModelItem::class);
    }

    public function brandAttributes()
    {
        return $this->hasMany(Attribute::class, 'brand_id', 'id');
    }

    public function categoryAttributes()
    {
        return $this->hasMany(Attribute::class, 'category_id', 'id');
    }

    public function allAttributes(): array
    {
        return array_merge(
            $this->categoryAttributes()->orderBy('sort')->getModels(),
            $this->brandAttributes()->orderBy('sort')->getModels()
        );
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /*public function getPath()
    {
        return $this->region ? "{$this->region->slug}/{$this->slug}" : $this->slug;
    }*/

    public function getImage(): string
    {
        if (!$this->image) {
            return '/default';
        }
        return "storage/{$this->image}";
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
