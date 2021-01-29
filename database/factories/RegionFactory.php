<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Arr;
use App\Entity\Catalog\Region;
use Illuminate\Support\Str;

$factory->define(Region::class, function (Faker $faker) {
    $list = ['Японский регион', 'Китайский регион', 'Индийский регион', 'США'];

    return [
        'name' => $name = Arr::random($list),
        'slug' => Str::slug($name)
    ];
});
