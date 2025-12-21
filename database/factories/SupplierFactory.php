<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    protected $model = \App\Models\Supplier::class;

    public function definition()
    {
        return [
            'name' => fake()->company(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'shopname' => fake()->companySuffix(),
            'photo' => null,
            'bank_name' => fake()->company(),
        ];
    }
}
