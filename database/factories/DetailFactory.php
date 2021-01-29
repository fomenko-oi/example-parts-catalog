<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Entity\Catalog\Model\Mark\Detail;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

$factory->define(Detail::class, function (Faker $faker) {
    $status = Arr::random(array_keys(Detail::getStatusesList()));

    $price = random_int(1, 9999);

    if (in_array($status, [Detail::STATUS_BY_REQUEST, Detail::STATUS_EXCHANGE, Detail::STATUS_DISCONTINUED])) {
        $price = null;
    }

    return [
        'name' => $faker->streetName,
        'sku' => $faker->streetName,
        'description' => random_int(0, 2) === 2 ? $faker->streetName : null,
        'use_count' => random_int(0, 100),
        'quantity' => random_int(0, 999),
        'weight' => random_int(0, 3) === 3 ? random_int(0, 999) : null,
        'price' => $price,
        'status' => $status,
        'visible' => true
    ];
});
