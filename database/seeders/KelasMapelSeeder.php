<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class KelasMapelSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Ambil semua id kelas dan mapel dari database
        $kelasIds = DB::table('kelas')->pluck('id')->toArray();
        $mapelIds = DB::table('mapel')->pluck('id')->toArray();

        // Buat data relasi kelas_mapel sebanyak 50 contoh
        for ($i = 0; $i < 50; $i++) {
            DB::table('kelas_mapel')->insert([
                'kelas_id' => $faker->randomElement($kelasIds),
                'mapel_id' => $faker->randomElement($mapelIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
