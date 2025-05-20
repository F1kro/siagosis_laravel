<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        // Generate 15 jadwal acak
        Jadwal::factory()->count(15)->create();
    }
}
