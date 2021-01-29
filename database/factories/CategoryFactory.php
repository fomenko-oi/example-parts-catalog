<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Entity\Catalog\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->unique()->slug(2),
        'image' => 'images/home'. rand(1, 11) .'.png',
    ];
});
