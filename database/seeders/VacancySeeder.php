<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Vacancy;

class VacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyIds = Company::pluck('id')->toArray();

        foreach($companyIds as $companyId){    
            Vacancy::factory()->create([
                'name' => 'Vacancy Examp.'/* str::random(8) */,
                'bio' => str::random(30),
                'company_id' => $companyId,
            ]);
        }
    }
}
