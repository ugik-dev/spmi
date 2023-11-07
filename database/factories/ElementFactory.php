<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Element; // Correct the namespace if needed

$factory->define(Element::class, function (Faker $faker) {
    static $indikator_ids = [];

    // We'll only create an Indikator if we haven't already, to avoid duplicate key issues.
    if (empty($indikator_ids)) {
        for ($i = 1; $i <= 100; $i++) { // Assuming you want 100 indikators
            $indikator = factory(App\Indikator::class)->create();
            $indikator_ids[] = $indikator->id;
        }
    }

    $prodis_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];
    $l1_s_ids = [1, 2, 3, 4, 5, 6, 7, 8];
    $l2_s_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26];

    $l4_s_ids = [1, 2, 3, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54];

    $l3_s_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27];

    return [
        'prodi_id' => $faker->randomElement($prodis_ids),
        'l1_id' => $faker->randomElement($l1_s_ids),
        'l2_id' => $faker->randomElement($l2_s_ids),
        'l3_id' => $faker->randomElement($l3_s_ids),
        'l4_id' => $faker->randomElement($l4_s_ids),
        'indikator_id' => $faker->randomElement($indikator_ids),
        'bobot' => $faker->optional()->randomFloat(2, 0, 1), // Adjusted max to 1 based on the decimal(3,2) constraint
        'score_berkas' => $faker->optional()->randomFloat(2, 0, 1),
        'score_hitung' => $faker->optional()->randomFloat(2, 0, 100), // Adjusted max based on the decimal(4,2) constraint
        'count_berkas' => $faker->optional()->numberBetween(0, 1000),
        'min_akreditasi' => $faker->optional()->randomFloat(2, 0, 1),
        'status_akreditasi' => $faker->optional()->randomElement(['F', 'Y', 'N']),
        'min_unggul' => $faker->optional()->randomFloat(2, 0, 1),
        'status_unggul' => $faker->optional()->randomElement(['F', 'Y', 'N']),
        'min_baik' => $faker->optional()->randomFloat(2, 0, 1),
        'status_baik' => $faker->optional()->randomElement(['F', 'Y', 'N']),
        'ket_auditor' => $faker->optional()->sentence,
    ];
});
