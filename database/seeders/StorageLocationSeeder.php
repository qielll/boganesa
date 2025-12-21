<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StorageLocation;

class StorageLocationSeeder extends Seeder
{
    public function run(): void
    {
        StorageLocation::factory()->count(5)->create();
    }
}