<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupplyOrder>
 */
use App\Models\Supplier;
use App\Enums\PurchaseStatus;

class SupplyOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'order_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(PurchaseStatus::cases()),
            'total_amount' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}
