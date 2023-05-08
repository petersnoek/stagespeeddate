<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'first_name' => 'Teacher',
            'last_name' => 'Teacher',
            'email' => 'Teacher@gmail.com',
            'password' => 'Teacher123',
            'role' => 'Teacher',
        ]);

        \App\Models\User::factory()->create([
            'first_name' => 'company',
            'last_name' => 'company',
            'email' => 'company1@gmail.com',
            'password' => 'company123',
            'role' => 'company',
        ]);

        \App\Models\User::factory()->create([
            'first_name' => 'student',
            'last_name' => 'student',
            'email' => 'student@gmail.com',
            'password' => 'student123',
            'role' => 'student',
        ]);
    }
}
