<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 5 kelas secara acak menggunakan factory
        Kelas::factory()->count(5)->create();
    }
}
