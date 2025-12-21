<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplying>
 */
class SupplyingFactory extends Factory
{
    protected $model = \App\Models\Supplying::class;

    public function definition()
    {
        return [
            'supplier_id' => \App\Models\Supplier::factory(),
            'item_id' => \App\Models\Item::factory(),
        ];
    }
}

