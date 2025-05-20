<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run()
    {
        Guru::create([
            'user_id' => 2,
            'nama' => "Fiqro Najiah",
            'nip' => '19800101',
            'telepon' => '081234567891',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1980-01-01',
            'pendidikan_terakhir' => 'S2 Pendidikan',
            'alamat' => 'Jl. Guru Hebat',
        ]);

        Guru::factory()->count(10)->create();

    }

}
