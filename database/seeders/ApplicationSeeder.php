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
        $vacancyIds = Vacancy::pluck('id')->first();
        $studentIds = Student::pluck('id')->first();
    
        Application::factory()->create([
            'vacancy_id' => $vacancyIds,
            'student_id' => $studentIds,
            'motivation' => 'Motivations/testdata',
            'comment' => str::random(30),
        ]);
    }
}
