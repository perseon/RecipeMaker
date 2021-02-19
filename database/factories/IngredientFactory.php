<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Ingredient::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'um' => 'ml',
        'cant' => $faker->numberBetween(0,500),
        'cant_r' => $faker->numberBetween(0,500),
        'proteine' => $faker->numberBetween(0,500),
        'lipide' => $faker->numberBetween(0,500),
        'glucide' => $faker->numberBetween(0,500)
    ];
});
