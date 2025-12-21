<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplying>
 */
use App\Models\Supplier;
use App\Models\Item;

class SupplyingFactory extends Factory
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
            'item_id' => Item::factory(),
            'quantity' => $this->faker->numberBetween(50, 500),
            'supply_date' => $this->faker->date(),
        ];
    }
}
