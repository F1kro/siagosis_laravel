<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        // Tambah 10 berita random
        Berita::factory()->count(10)->create();
    }
}
