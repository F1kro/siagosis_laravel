<?php

namespace Database\Seeders;

use App\Models\Orangtua;
use Illuminate\Database\Seeder;

class OrangtuaSeeder extends Seeder
{
    public function run()
    {

        Orangtua::create([
            'user_id' => 4,
            'siswa_id' =>1,
            'nama' => 'Budi Wali',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Wali Murid',
            'pekerjaan' => 'PNS',
        ]);
    }
}