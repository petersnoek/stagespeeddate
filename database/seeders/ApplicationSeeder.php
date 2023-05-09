<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vacancyIds = \App\Models\Vacancy::pluck('id')->toArray();
        $studentIds = \App\Models\Student::pluck('id')->toArray();
    
        \App\Models\Application::factory()->create([
            'vacancy_id' => $vacancyIds[array_rand($vacancyIds)],
            'student_id' => $studentIds[array_rand($studentIds)],
            'comment' => str::random(30),
        ]);
    }
}
