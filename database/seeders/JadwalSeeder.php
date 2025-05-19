<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        // Jadwal Matematika kelas X-A (Senin)
        Jadwal::create([
            'kelas_id' => 1,
            'mapel_id' => 1,
            'guru_id' => 1,
            'hari' => 'Senin',
            'jam_mulai' => '07:00:00',
            'jam_selesai' => '08:30:00',
            'ruangan' => 'Ruang 101',
            'tahun_ajaran' => '2023/2024',
            'semester' => 'Ganjil',
        ]);

       
    }
}