<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    protected $model = \App\Models\OrderDetail::class;

    public function definition()
    {
        return [
            'supply_order_id' => \App\Models\SupplyOrder::factory(),
            'payment_type' => fake()->randomElement(['cash', 'transfer', 'credit']),
        ];
    }
}

