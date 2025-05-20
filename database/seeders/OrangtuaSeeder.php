<?php

namespace Database\Seeders;

use App\Models\Orangtua;
use Illuminate\Database\Seeder;

class OrangtuaSeeder extends Seeder
{
    public function run(): void
    {
        Orangtua::factory()->count(10)->create();
    }
}
