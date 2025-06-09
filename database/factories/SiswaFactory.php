<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nisn' => $this->faker->unique()->numerify('############'),
            'nama' => $this->faker->name,
            'kelas_id' => Kelas::inRandomOrder()->first()->id ?? 1, // fallback to ID 1
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'alamat' => $this->faker->address,
            'tanggal_lahir' => $this->faker->date('Y-m-d', '-10 years'),
            'tempat_lahir' => $this->faker->city,
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Hindu', 'Budha']),
            'foto' => null,
            'user_id' => User::where('role', 'siswa')->first()->id,
        ];
    }
}
