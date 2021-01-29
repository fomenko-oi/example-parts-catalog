<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Entity\Catalog\Attribute;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

$factory->define(Attribute::class, function (Faker $faker) {
    $type = Arr::random(array_keys(Attribute::getTypesList()));

    $variants = [];

    if ($type === Attribute::TYPE_SELECT) {
        $variants = array_map(function() use($faker) {
            return $faker->colorName;
        }, array_fill(0, 5, 1));
    }
    if ($type === Attribute::TYPE_RANGE) {
        $variants = [random_int(0, 999), random_int(1000, 1000000)];
    }
    if ($type === Attribute::TYPE_LESS || $type === Attribute::TYPE_GREATER) {
        $variants = [random_int(0, 999)];
    }
    if ($type === Attribute::TYPE_FLOAT) {
        $variants = [$faker->randomFloat()];
    }
    if ($type === Attribute::TYPE_INTEGER) {
        $variants = [random_int(1, 99999999)];
    }
    if ($type === Attribute::TYPE_STRING) {
        $variants = [Str::random()];
    }

    return [
        'name' => $faker->streetName,
        'type' => $type,
        'required' => $faker->boolean,
        'label' => $faker->streetName,
        'default' => random_int(0, 2) === 1 ? $faker->streetName : null,
        'variants' => $variants,
        'sort' => 0,
    ];
});
