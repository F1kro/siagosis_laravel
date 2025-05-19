<?php

namespace Database\Seeders;

use App\Models\Mapel;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run()
    {
        $mapel = [
            [
                'kode' => 'MTK001',
                'nama' => 'Matematika',
                'kelas' => 'X',
                'kkm' => 75,
                'jumlah_jam' => 4,
            ],
            [
                'kode' => 'BIN001',
                'nama' => 'Bahasa Indonesia',
                'kelas' => 'X',
                'kkm' => 75,
                'jumlah_jam' => 4,
            ],
            [
                'kode' => 'BIG001',
                'nama' => 'Bahasa Inggris',
                'kelas' => 'X',
                'kkm' => 75,
                'jumlah_jam' => 4,
            ],
            [
                'kode' => 'FIS001',
                'nama' => 'Fisika',
                'kelas' => 'X',
                'kkm' => 75,
                'jumlah_jam' => 3,
            ],
            [
                'kode' => 'KIM001',
                'nama' => 'Kimia',
                'kelas' => 'X',
                'kkm' => 75,
                'jumlah_jam' => 3,
            ],
        ];

        foreach ($mapel as $m) {
            Mapel::create($m);
        }
    }
}