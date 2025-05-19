<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Ambil semua user yang role-nya 'siswa'
        $siswaUsers = User::where('role', 'siswa')->get();

        foreach ($siswaUsers as $user) {
            Siswa::create([
                'user_id' => $user->id,
                'nama' => $faker->name,
                'nisn' => $faker->numerify('############'),
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date(),
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Hindu', 'Budha']),
                'alamat' => $faker->address,
                'kelas_id' => 1, // Pastikan kelas ID ini valid
                'foto' => null, // Bisa dikosongkan, sesuaikan dengan kebutuhan
            ]);
        }
    }
}
