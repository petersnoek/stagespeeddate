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
        
        //create student row for first student user and asign them to the first teacher
        Student::factory()->create([
            'user_id' => $userIds[0],
            'teacher_id' => $teacherIds[0],
            'CV' => 'CV/aAjVP,CV test data.pdf'
        ]);

        array_shift($userIds); //gets rid of the first userid in the array
        //create student rows for all other student users but don't assign a teacher
        foreach($userIds as $userId){
            Student::factory()->create([
                'user_id' => $userId,
                'teacher_id' => null,
            ]);
        }
    }
}
