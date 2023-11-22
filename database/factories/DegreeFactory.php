<?php

namespace Database\Factories;

use App\Degree;
use Faker\Generator as Faker;

$factory->define(Degree::class, function (Faker $faker) {
  return [
    'name' => $faker->unique()->words(3, true), // Example: 'Bachelor of Science'
    'code' => $faker->unique()->bothify('###??'), // Example: '123AB'
  ];
});
