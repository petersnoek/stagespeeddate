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
            for ($i=1; $i < 6; $i++) { 
                Vacancy::factory()->create([
                    'company_id' => $companyId,
                    'name' => 'Vacancy Examp.'.$i/* str::random(8) */,
                    'bio' => str::random(30),
                ]);
            }    
            
        }
    }
}
