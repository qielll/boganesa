<?php

namespace Database\Factories;

use App\Enums\SupplierType;

class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'address' => fake()->address(),
            'shopname' => fake()->company(),
            'photo' => fake()->imageUrl(), // Added photo field
            'bank_name' => fake()->randomElement(['BRI', 'BNI', 'BCA', 'BSI', 'Mandiri']),
            'supplier_type' => fake()->randomElement(SupplierType::cases()), // Changed 'type' to 'supplier_type'
        ];
    }
}
