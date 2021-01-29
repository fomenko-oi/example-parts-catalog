<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Entity\Catalog\Model\Mark;

$factory->define(Mark::class, function (Faker $faker) {
    return [
        'name' => $faker->randomNumber(),
        'sku' => $faker->randomNumber(),
        'image' => 'images/component1.png'
    ];
});
