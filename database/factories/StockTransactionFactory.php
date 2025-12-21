<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockTransaction>
 */
class StockTransactionFactory extends Factory
{
    protected $model = \App\Models\StockTransaction::class;

    public function definition()
    {
        return [
            'item_id' => \App\Models\Item::factory(),
            'transaction_type' => fake()->randomElement(['in', 'out']),
            'quantity' => fake()->numberBetween(1, 50),
            'transaction_date' => now(),
            'stock_transaction_notes' => fake()->sentence(),
        ];
    }
}

