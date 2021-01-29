<?php

use Illuminate\Database\Seeder;
use App\Entity\Catalog\Category;
use App\Entity\Catalog\Region;
use App\Entity\Catalog\Brand;
use App\Entity\Catalog\Attribute;
use App\Entity\Catalog\Model\Mark;
use App\Entity\Catalog\Model\ModelItem;
use App\Entity\Catalog\Model\Mark\Group;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        Category::where('id', '>', 0)->delete();
        Region::where('id', '>', 0)->delete();
        Brand::where('id', '>', 0)->delete();
        Attribute::where('id', '>', 0)->delete();

        factory(Category::class, 8)->create()
            ->each(function (Category $category) {
                $category->attributes()->saveMany(factory(Attribute::class, random_int(3, 7))->make());

                //$category->children()->saveMany(factory(Category::class, random_int(1, 7))->make());
                $category->regions()->saveMany(factory(Region::class, random_int(1, 4))->make())->each(function (
                    Region $region
                ) use($category) {
                    if (random_int(1, 4) === 4) {
                        return;
                    }

                    $region->brands()->saveMany(factory(Brand::class, random_int(1, 4))->make())->each(function (
                        Brand $brand
                    ) use ($region, $category) {
                        if (random_int(1, 4) === 4) {
                            return;
                        }

                        $brand->models()->saveMany(factory(ModelItem::class, random_int(10, 30))->make([
                            'region_id' => $region->id
                        ]))
                            ->each(function (ModelItem $model) use($category) {
                                if (random_int(1, 4) === 4) {
                                    return;
                                }

                                $model->marks()->saveMany(factory(Mark::class, random_int(1, 20))->make())->each(function (Mark $mark) use ($category) {
                                    if (random_int(1, 4) === 4) {
                                        return;
                                    }

                                    /** @var Attribute $attribute */
                                    foreach ($category->attributes()->get() as $attribute) {
                                        $mark->values()->create([
                                            'attribute_id' => $attribute->id,
                                            'value' => random_int(0, 4) === 1 ? random_int(1, 999999) : Str::random()
                                        ]);
                                    }

                                    $mark->groups()->saveMany(factory(Group::class, random_int(1, 10))->make());
                                });
                            });
                    });
                });

                /*if (rand(0, 3) === 3) {
                    $regions->each(function(Region $region) {
                        $region->brands()->saveMany(factory(Brand::class, random_int(1, 3))->make([
                            'region_id' => $region->id
                        ]));
                    });
                } else {
                    $category->brands()->saveMany(factory(Brand::class, random_int(1, 3))->make([
                        'category_id' => $category->id
                    ]));
                }*/
            });
    }
}
