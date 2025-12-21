<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    protected $model = \App\Models\Item::class;

    public function definition()
    {
        return [
            'category_id' => \App\Models\Category::factory(),
            'unit_id' => \App\Models\Unit::factory(),
            'detailorder_id' => \App\Models\OrderDetail::factory(),
            'location_id' => \App\Models\StorageLocation::factory(),
            'user_id' => \App\Models\User::factory(),
            'item_name' => fake()->words(2, true),
            'reorder_level' => fake()->numberBetween(5, 50),
            'exp_date' => now()->addMonths(6),
            'item_quantity' => fake()->numberBetween(1, 200),
            'item_date_add' => now(),
        ];
    }
}

