<?php

namespace Database\Factories;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalFactory extends Factory
{
    public function definition(): array
    {
        $startTime = $this->faker->time('H:i:s');
        $endTime = date("H:i:s", strtotime($startTime) + 5400); // +90 menit

        return [
            'kelas_id' => Kelas::inRandomOrder()->first()?->id ?? 1,
            'mapel_id' => Mapel::inRandomOrder()->first()?->id ?? 1,
            'guru_id' => Guru::inRandomOrder()->first()?->id ?? 1,
            'hari' => $this->faker->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']),
            'jam_mulai' => $startTime,
            'jam_selesai' => $endTime,
            'ruangan' => 'Ruang ' . $this->faker->numberBetween(101, 110),
            'tahun_ajaran' => '2023/2024',
            'semester' => $this->faker->randomElement(['Ganjil', 'Genap']),
        ];
    }
}
