<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Entity\Catalog\Model\ModelItem;

$factory->define(ModelItem::class, function (Faker $faker) {
    return [
        'name' => rand(0, 4) === 1 ? $faker->randomNumber() . $faker->randomLetter : $faker->domainName,
        'group' => rand(0, 4) === 1 ? null : array_map(function($item) use($faker) {
            return $faker->name;
        }, array_fill(0, rand(1, 6), 0)),
        'slug' => $faker->unique()->slug,
    ];
});
