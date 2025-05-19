<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        // admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@school.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // guru
        User::create([
            'name' => 'guru',
            'email' => 'guru@siagosis.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        // siswa
        User::create([
            'name' => 'siswa',
            'email' => 'siswa@siagosis.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        // orangtua
        User::create([
            'name' => 'ortu',
            'email' => 'ortu@siagosis.com',
            'password' => Hash::make('password'),
            'role' => 'orangtua',
        ]);

        // Generate 20 siswa menggunakan Faker
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]);
        }
    }
}
