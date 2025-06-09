<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            // GuruSeeder::class,
            // SiswaSeeder::class, // <== Gaperlu, karena sudah dijalankan oleh UserSeeder
            UserSeeder::class,
            KelasSeeder::class,
            OrangtuaSeeder::class,
            MapelSeeder::class,
            GuruMapelSeeder::class,
            JadwalSeeder::class,
            BeritaSeeder::class,
            KelasMapelSeeder::class,
        ]);
    }
}