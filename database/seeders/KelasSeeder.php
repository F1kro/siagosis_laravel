<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run()
    {
        Kelas::create([
            'kode_kelas' => 'K001',
            'nama_kelas' => 'X-A',
            'guru_id' => 1, // Budi Santoso
            'tahun_ajaran' => '2023/2024',
        ]);

        Kelas::create([
            'kode_kelas' => 'K002',
            'nama_kelas' => 'X-B',
            'guru_id' => 1, // Siti Rahayu
            'tahun_ajaran' => '2023/2024',
        ]);
    }
}