<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Entity\Catalog\Brand;

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->unique()->slug,
        'image' => 'images/' . \Illuminate\Support\Arr::random(['Suzuki_logo', 'images/kawasaki-logo', 'yamaha', 'honda']) . '.png',
    ];
});
