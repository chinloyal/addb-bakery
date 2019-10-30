<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ingredient;
use Faker\Generator as Faker;

$factory->define(Ingredient::class, function (Faker $faker) {
    return [
		'name' => $faker->word,
		'measurement_unit' => $faker->word,
		'current_quantity' => $faker->numberBetween(5, 20),
		'reorder_level' => $faker->randomElement(['H', 'M', 'L'])
    ];
});
