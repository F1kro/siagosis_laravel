<?php

namespace Database\Seeders;

use App\Models\GuruMapel;
use Illuminate\Database\Seeder;

class GuruMapelSeeder extends Seeder
{
    public function run()
    {
        // Budi Santoso mengajar Matematika di kelas X-A
        GuruMapel::create([
            'guru_id' => 1,
            'mapel_id' => 1,
            'kelas_id' => 1,
            'tahun_ajaran' => '2023/2024',
        ]);

      
    }
}