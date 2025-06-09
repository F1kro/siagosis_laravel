<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrangtuaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name,
            'telepon' => $this->faker->phoneNumber,
            'alamat' => $this->faker->address,
            'pekerjaan' => $this->faker->randomElement(['PNS', 'Wiraswasta', 'Guru', 'Dokter', 'Petani']),
            'siswa_id' => Siswa::inRandomOrder()->first()?->id ?? 1,
            'user_id' => User::factory(),
        ];
    }
}
