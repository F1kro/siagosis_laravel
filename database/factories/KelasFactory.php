<?php

namespace Database\Factories;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    public function definition(): array
    {
        static $counter = 1;

        return [
            'kode_kelas' => 'K' . str_pad($counter++, 3, '0', STR_PAD_LEFT),
            'nama_kelas' => $this->faker->randomElement(['X-A', 'X-B', 'XI-A', 'XI-B', 'XII-A', 'XII-B']),
            'guru_id' => Guru::inRandomOrder()->first()->id ?? 1,
            'tahun_ajaran' => $this->faker->randomElement(['2023/2024', '2024/2025']),
        ];
    }
}
