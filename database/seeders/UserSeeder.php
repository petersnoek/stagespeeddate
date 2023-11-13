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
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin123'),
            'role' => 'admin',
            'profilePicture' => 'media/usericons/Icon4.png',
            'stage' => 0
        ]);

        User::factory()->create([
            'first_name' => 'Teacher',
            'last_name' => 'de Teacher',
            'email' => 'teacher@gmail.com',
            'password' => Hash::make('Teacher123'),
            'role' => 'teacher',
            'profilePicture' => 'media/usericons/Icon10.png',
            'stage' => 0
        ]);

        User::factory()->create([
            'first_name' => 'Company',
            'last_name' => 'de Company',
            'email' => 'company@gmail.com',
            'password' => Hash::make('Company123'),
            'role' => 'company',
            'profilePicture' => 'media/usericons/Icon7.png',
            'stage' => 0
        ]);
        User::factory()->create([
            'first_name' => 'Company2',
            'last_name' => 'company',
            'email' => 'company2@gmail.com',
            'password' => Hash::make('Company123'),
            'role' => 'company',
            'profilePicture' => 'media/usericons/Icon8.png',
            'stage' => 0
        ]);

        User::factory()->create([
            'first_name' => 'Student',
            'last_name' => 'de Student',
            'email' => 'student@mydavinci.nl',
            'password' => Hash::make('Student123'),
            'role' => 'student',
            'profilePicture' => 'media/usericons/Icon9.png',
            'stage' => 0
        ]);
        
        for($x=2; $x < 6; $x++){
            User::factory()->create([
                'first_name' => 'Student'.$x,
                'last_name' => 'de Student',
                'email' => 'student'.$x.'@mydavinci.nl',
                'password' => Hash::make('Student123'),
                'role' => 'student',
                'profilePicture' => 'media/usericons/Icon' . random_int(1, 10) . '.png',
                'stage' => 0
            ]);
        }
    }
}
