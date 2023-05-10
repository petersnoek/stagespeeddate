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
                $bio = '';
                //create a 'bio' with 10 to 30 random giberish 'words'
                for ($x=0; $x < rand(50, 100); $x++) { 
                    $bio = $bio . ' ' . str::random(rand(1,7));
                }
                Vacancy::factory()->create([
                    'company_id' => $companyId,
                    'name' => 'Stage '.$i/* str::random(8) */,
                    'bio' => $bio /* str::random(90) */,
                ]);
            }    
            
        }
    }
}
