<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Target;
use Faker\Generator as Faker;

$factory->define(Target::class, function (Faker $faker) {
    $l1_s_ids = [1, 2, 3, 4, 5, 6, 7, 8];
    $prodis_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];
    return [
        'l1_id' =>  $faker->randomElement($l1_s_ids), // random or null
        'prodi_id' => $faker->randomElement($prodis_ids), // random or null
        'value' => $faker->optional()->randomFloat(2, 0, 100), // random decimal value
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
