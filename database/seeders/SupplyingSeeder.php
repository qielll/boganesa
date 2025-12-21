<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplying;

class SupplyingSeeder extends Seeder
{
    public function run(): void
    {
        Supplying::factory()->count(20)->create();
    }
}