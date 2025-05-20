<?php

namespace Database\Seeders;

// use App\Models\Mapel;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Mapel::factory()->count(10)->create();

    }
}


