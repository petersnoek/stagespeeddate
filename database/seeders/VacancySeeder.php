<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class VacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyIds = \App\Models\Company::pluck('id')->toArray();

        foreach($companyIds as $companyId){    
            \App\Models\Vacancy::factory()->create([
                'name' => str::random(8),
                'bio' => str::random(30),
                'company_id' => $companyId,
            ]);
        }
    }
}
