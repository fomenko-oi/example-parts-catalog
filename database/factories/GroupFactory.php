<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Entity\Catalog\Model\Mark\Group;
use Illuminate\Support\Arr;

$factory->define(Group::class, function (Faker $faker) {
    $subjects = ['Двигатель', 'Комплект прокладок', 'Рама', 'Аксессуары', 'Другое'];

    return [
        'name' => $faker->streetName,
        'description' => random_int(0, 4) === 1 ? $faker->text : null,
        'image' => 'images/draw.png',
        'subject' => random_int(0, 4) === 1 ? null : Arr::random($subjects),
    ];
});
