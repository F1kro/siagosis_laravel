<?php

namespace Database\Factories;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuruMapelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'guru_id' => Guru::inRandomOrder()->first()?->id ?? 1,
            'mapel_id' => Mapel::inRandomOrder()->first()?->id ?? 1,
            'kelas_id' => Kelas::inRandomOrder()->first()?->id ?? 1,
            'tahun_ajaran' => '2023/2024',
        ];
    }
}
