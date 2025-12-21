<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupplyOrder>
 */
class SupplyOrderFactory extends Factory
{
    protected $model = \App\Models\SupplyOrder::class;

    public function definition()
    {
        return [
            'supplier_id' => \App\Models\Supplier::factory(),
            'order_date' => now(),
            'item_ordered' => fake()->words(3, true),
            'order_quantity' => fake()->numberBetween(1, 100),
            'item_price' => fake()->randomFloat(2, 1000, 100000),
            'total_cost' => fake()->randomFloat(2, 1000, 100000),
            'ordered_by' => fake()->name(),
            'supply_order_notes' => fake()->sentence(),
        ];
    }
}

