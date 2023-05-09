<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacherIds = \App\Models\Teacher::pluck('id')->toArray();
        $userIds = \App\Models\User::where('role','student')->pluck('id')->toArray();
        
        foreach(range(1,4) as $index){
            \App\Models\Student::factory()->create([
                'id' => $index,
                'user_id' => $userIds[array_rand($userIds)],
                'teacher_id' => $teacherIds[array_rand($teacherIds)],
                'cv' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
