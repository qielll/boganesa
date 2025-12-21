<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    protected $model = \App\Models\Unit::class;

    public function definition()
    {
        return [
            'name' => fake()->word(),
            'slug' => fake()->slug(),
            'short_code' => strtoupper(fake()->lexify('??')),
        ];
    }
}
