<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Degree; // Ensure this is the correct namespace for your Degree model
use Faker\Generator as Faker;

$factory->define(Degree::class, function (Faker $faker) {
  return [
    'name' => $faker->unique()->words(3, true), // Example: 'Bachelor of Science'
    'code' => $faker->unique()->bothify('###??'), // Example: '123AB'
  ];
});
