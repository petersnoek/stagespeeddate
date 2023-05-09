<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Vacancy;
use App\Models\Application;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vacancyIds = Vacancy::pluck('id')->toArray();
        $studentIds = Student::pluck('id')->toArray();
    
        Application::factory()->create([
            'vacancy_id' => $vacancyIds[array_rand($vacancyIds)],
            'student_id' => $studentIds[array_rand($studentIds)],
            'comment' => str::random(30),
        ]);
    }
}
