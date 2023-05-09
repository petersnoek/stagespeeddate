<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacherIds = Teacher::pluck('id')->toArray();
        $userIds = User::where('role','student')->pluck('id')->toArray();
        
        foreach(range(1,1) as $index){
            Student::factory()->create([
                'id' => $index,
                'user_id' => $userIds[array_rand($userIds)],
                'teacher_id' => $teacherIds[array_rand($teacherIds)],
                'CV' => '',
            ]);
        }
    }
}
