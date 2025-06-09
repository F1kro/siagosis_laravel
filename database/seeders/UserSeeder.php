<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Orangtua;
use App\Models\Siswa;
use App\Models\User;
use Database\Factories\KelasFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        /* ==> Users dengan factory: sekalian insert data siswa, guru, orangtua <== */

        // Users untuk guru
        $guruUsers = User::factory()->count(10)->create([
            'role' => 'guru',
        ]);
        $guruUsers->each(function ($user) {
            Guru::factory()->create([
                'user_id' => $user->id,
            ]);
        });

        // Ambil 5 guru acak untuk jadi wali kelas unik
        $guruIds = Guru::inRandomOrder()->limit(5)->pluck('id');
        // Buat 5 kelas pakai factory, tapi override `guru_id`
        $guruIds->each(function ($guruId) {
            Kelas::factory()->create([
                'guru_id' => $guruId
            ]);
        });

        // Users untuk siswa
        $siswaUsers = User::factory()->count(20)->create([
            'role' => 'siswa',
        ]);
        $siswaUsers->each(function ($user) {
            Siswa::factory()->create([
                'user_id' => $user->id,
                'kelas_id' => Kelas::inRandomOrder()->first()->id,
            ]);
        });

        // Users untuk orangtua
        // Ambil semua siswa yang sudah disimpan
        $siswaIds = Siswa::pluck('id')->shuffle();
        $ortuUsers = User::factory()->count(20)->create([
            'role' => 'orangtua',
        ]);
        $ortuUsers->each(function ($user, $index) use ($siswaIds) {
            Orangtua::factory()->create([
                'user_id' => $user->id,
                'siswa_id' => $siswaIds[$index % $siswaIds->count()], // pastikan valid dan menyebar
            ]);
        });

        /* ==> Manual User <== */
        // Admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@siagosis.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Guru
        $guruUser = User::create([
            'name' => 'juan',
            'email' => 'juan@siagosis.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);
        Guru::factory()->create(['user_id' => $guruUser->id]);

        // Siswa
        $siswaUser = User::create([
            'name' => 'majdi',
            'email' => 'majdi@siagosis.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);
        Siswa::factory()->create([
            'user_id' => $siswaUser->id,
            'kelas_id' => Kelas::inRandomOrder()->first()->id
        ]);

        // Orangtua
        $ortuUser = User::create([
            'name' => 'opik',
            'email' => 'opik@siagosis.com',
            'password' => Hash::make('password'),
            'role' => 'orangtua',
        ]);
        Orangtua::factory()->create(['user_id' => $ortuUser->id]);
    }
}
