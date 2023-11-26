<?php

namespace Database\Factories;

use App\Criterion;
use Illuminate\Database\Eloquent\Factories\Factory;

class CriterionFactory extends Factory
{
  protected $model = Criterion::class;

  public function definition()
  {
    $parent_id = null;
    $code = '';

    if (Criterion::whereNull('parent_id')->count() < 26) {
      // Attempt to create a top-level parent with a single-letter code
      $code = strtoupper($this->faker->randomLetter);
    } else {
      // All single-letter codes are taken, create a child criterion
      $parent = Criterion::inRandomOrder()->first();
      $parent_id = $parent->id;

      // Generate a unique code for the child
      do {
        $childCode = strtoupper($this->faker->bothify('##'));
        $code = $parent->code . '.' . $childCode;
      } while (Criterion::where('code', $code)->exists());
    }

    return [
      'name' => $this->faker->words(3, true),
      'code' => $code,
      'parent_id' => $parent_id
    ];
  }
}
