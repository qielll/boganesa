<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SupplyOrder;

class SupplyOrderSeeder extends Seeder
{
    public function run(): void
    {
        SupplyOrder::factory()->count(10)->create();
    }
}