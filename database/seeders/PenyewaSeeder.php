<?php

namespace Database\Seeders;

use App\Models\penyewa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenyewaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        penyewa::factory()->count(10)->create();
    }
}
