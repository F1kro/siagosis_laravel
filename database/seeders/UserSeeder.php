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
            'email' => 'admin@school.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }

}
