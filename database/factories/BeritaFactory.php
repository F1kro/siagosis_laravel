<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BeritaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence(6),
            'konten' => $this->faker->paragraphs(3, true),
            'kategori' => $this->faker->randomElement(['Pengumuman', 'Kegiatan', 'Prestasi', 'Umum']),
            'user_id' => User::where('role', 'admin')->inRandomOrder()->first()?->id ?? 1,
            'status' => $this->faker->randomElement(['Dipublikasikan', 'Draft']),
        ];
    }
}
