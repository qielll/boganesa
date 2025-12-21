<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockTransaction>
 */
use App\Models\Item;

class StockTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_id' => Item::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'transaction_type' => $this->faker->randomElement(['in', 'out', 'adjustment']),
            'transaction_date' => $this->faker->dateTimeThisYear(),
            'notes' => $this->faker->sentence(),
        ];
    }
}
