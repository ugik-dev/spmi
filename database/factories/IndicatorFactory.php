<?php

use Faker\Generator as Faker;
use App\Indikator; // Replace with the correct namespace of your Indikator model

$factory->define(Indikator::class, function (Faker $faker) {
    $jenjang_ids = [1, 4];
    $l1_s_ids = [1, 2, 3, 4, 5, 6, 7, 8];
    $l2_s_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26];
    $l3_s_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27];
    $l4_s_ids = [1, 2, 3, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54];

    return [
        'jenjang_id' => $faker->randomElement($jenjang_ids),
        'dec' => $faker->sentence,
        'l1_id' => $faker->randomElement($l1_s_ids),
        'l2_id' => $faker->optional()->randomElement($l2_s_ids),
        'l3_id' => $faker->optional()->randomElement($l3_s_ids),
        'l4_id' => $faker->optional()->randomElement($l4_s_ids),
    ];
});
