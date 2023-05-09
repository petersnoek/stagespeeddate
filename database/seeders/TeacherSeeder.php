<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $userIds = User::where('role','teacher')->pluck('id')->toArray();
        
        foreach($userIds as $userId){    
            Teacher::factory()->create([
                'user_id' => $userId,
            ]);
        }
    }
}
