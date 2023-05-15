<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'de Admin',
            'email' => 'admin@mydavinci.nl',
            'password' => Hash::make('Admin123'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'first_name' => 'Teacher',
            'last_name' => 'de Teacher',
            'email' => 'teacher@mydavinci.nl',
            'password' => Hash::make('Teacher123'),
            'role' => 'teacher',
        ]);

        User::factory()->create([
            'first_name' => 'Company',
            'last_name' => 'de Company',
            'email' => 'company@mydavinci.nl',
            'password' => Hash::make('Company123'),
            'role' => 'company',
        ]);

        User::factory()->create([
            'first_name' => 'Student',
            'last_name' => 'de Student',
            'email' => 'student@mydavinci.nl',
            'password' => Hash::make('Student123'),
            'role' => 'student',
        ]);
    }
}
