<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Berkas; // Assuming the model is App\Berkas

$factory->define(Berkas::class, function (Faker $faker) {
    $prodis_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];
    $l1_s_ids = [1, 2, 3, 4, 5, 6, 7, 8];
    $l2_s_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26];

    $l4_s_ids = [1, 2, 3, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54];

    $l3_s_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27];
    return [
        'element_id' => rand(1, 100), // You might want to use a real reference here
        'prodi_id' => $faker->randomElement($prodis_ids),
        'l1_id' => $faker->randomElement($l1_s_ids),
        'l2_id' => $faker->randomElement($l2_s_ids),
        'l3_id' => $faker->randomElement($l3_s_ids),
        'l4_id' => $faker->randomElement($l4_s_ids),
        'file_name' => $faker->word . '.pdf', // Assuming it's a file name
        'file' => $faker->url, // Assuming it's a file URL
        'dec' => $faker->text,
        'score' => $faker->randomFloat(2, 0, 1), // decimal(3,2)
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
