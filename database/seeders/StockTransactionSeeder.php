<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StockTransaction;

class StockTransactionSeeder extends Seeder
{
    public function run(): void
    {
        StockTransaction::factory()->count(30)->create();
    }
}