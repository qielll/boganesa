<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StorageLocation>
 */
class StorageLocationFactory extends Factory
{
    protected $model = \App\Models\StorageLocation::class;

    public function definition()
    {
        return [
            'location_name' => fake()->word(),
            'location_desc' => fake()->sentence(),
            'storage_date_add' => now(),
        ];
    }
}
