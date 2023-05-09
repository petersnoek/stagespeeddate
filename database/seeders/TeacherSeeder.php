<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $userIds = \App\Models\User::where('role','teacher')->pluck('id')->toArray();
        
        foreach($userIds as $userId){    
            \App\Models\Teacher::factory()->create([
                'user_id' => $userId,
            ]);
        }
    }
}
