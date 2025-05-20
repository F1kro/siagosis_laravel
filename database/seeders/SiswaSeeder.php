<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 20 siswa menggunakan factory
        Siswa::factory()->count(20)->create();
    }
}
