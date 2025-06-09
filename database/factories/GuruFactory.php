<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuruFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => null, // karena udah otomatis dari UserSeeder
            'nip' => $this->faker->unique()->numerify('1980####'),
            'nama' => $this->faker->name,
            'telepon' => $this->faker->phoneNumber,
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '-25 years'),
            'pendidikan_terakhir' => $this->faker->randomElement(['S1 Pendidikan', 'S2 Pendidikan']),
            'alamat' => $this->faker->address,
        ];
    }
}
