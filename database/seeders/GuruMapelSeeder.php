<?php

namespace Database\Seeders;

use App\Models\GuruMapel;
use Illuminate\Database\Seeder;

class GuruMapelSeeder extends Seeder
{
    public function run(): void
    {
        // Generate 15 relasi guru-mapel secara acak
        GuruMapel::factory()->count(15)->create();
    }
}
