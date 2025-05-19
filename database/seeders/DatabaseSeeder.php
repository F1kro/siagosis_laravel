<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            GuruSeeder::class,
            KelasSeeder::class,
            SiswaSeeder::class,
            OrangtuaSeeder::class,
            MapelSeeder::class,
            GuruMapelSeeder::class,
            JadwalSeeder::class,
            BeritaSeeder::class,
        ]);
    }
}