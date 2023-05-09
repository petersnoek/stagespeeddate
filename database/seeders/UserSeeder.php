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
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin123'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'first_name' => 'Teacher',
            'last_name' => 'teacher',
            'email' => 'teacher@gmail.com',
            'password' => Hash::make('Teacher123'),
            'role' => 'teacher',
        ]);
        /* User::factory()->create([
            'first_name' => 'Teacher2',
            'last_name' => 'teacher2',
            'email' => 'teacher2@gmail.com',
            'password' => Hash::make('Teacher123'),
            'role' => 'teacher',
        ]); */
        

        User::factory()->create([
            'first_name' => 'Company',
            'last_name' => 'company',
            'email' => 'company@gmail.com',
            'password' => Hash::make('Company123'),
            'role' => 'company',
        ]);

        User::factory()->create([
            'first_name' => 'Student',
            'last_name' => 'student',
            'email' => 'student@gmail.com',
            'password' => Hash::make('Student123'),
            'role' => 'student',
        ]);
    }
}
