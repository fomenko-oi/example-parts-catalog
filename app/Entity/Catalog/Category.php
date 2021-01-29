<?php

declare(strict_types=1);

namespace App\Entity\Catalog;

use App\Entity\Catalog\Discount\Discount;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Entity\Catalog\Category
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property string|null $name_ru
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Catalog\Attribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Catalog\Brand[] $brands
 * @property-read int|null $brands_count
 * @property-read \Kalnoy\Nestedset\Collection|\App\Entity\Catalog\Category[] $children
 * @property-read int|null $children_count
 * @property-read \App\Entity\Catalog\Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Catalog\Region[] $regions
 * @property-read int|null $regions_count
 * @method static \Kalnoy\Nestedset\Collection|static[] all($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Category d()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Catalog\Category findSimilarSlugs($attribute, $config, $slug)
 * @method static \Kalnoy\Nestedset\Collection|static[] get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Entity\Catalog\Category newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Entity\Catalog\Category newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Entity\Catalog\Category query()
 * @mixin \Eloquent
 * @property-read \App\Entity\Catalog\Discount\Discount|null $discount
 */
class Category extends Model
{
    use NodeTrait, Sluggable {
        NodeTrait::replicate as replicateNode;
        Sluggable::replicate as replicateSlug;
    }

    protected $table = 'catalog_categories';

    protected $fillable = [
        'name', 'name_ru', 'slug', 'image', 'parent_id', 'regions_enabled'
    ];

    protected $with = ['discount'];

    protected $casts = [
        'regions_enabled' => 'boolean'
    ];

    public function replicate(array $except = null)
    {
        $instance = $this->replicateNode($except);
        (new SlugService())->slug($instance, true);

        return $instance;
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'category_id', 'id');
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function discount()
    {
        return $this->morphOne(Discount::class, 'entity');
    }

    public function hasParent(): bool
    {
        return !empty($this->parent_id);
    }

    public function isWithEnabledRegions(): bool
    {
        return $this->regions_enabled;
    }

    public function getImage(): string
    {
        if (!$this->image) {
            return '/default';
        }
        return "storage/{$this->image}";
    }

    public function getRouteKeyName()
    {
        return 'slug';
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
