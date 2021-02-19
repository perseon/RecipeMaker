<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Recipe::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
