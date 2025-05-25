<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Manual users
        User::create([
            'name' => 'admin',
            'email' => 'admin@siagosis.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'juan',
            'email' => 'juan@siagosis.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);
        User::create([
            'name' => 'opik',
            'email' => 'opik@siagosis.com',
            'password' => Hash::make('password'),
            'role' => 'orangtua',
        ]);
        User::create([
            'name' => 'majdi',
            'email' => 'majdi@siagosis.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);
    }

}
