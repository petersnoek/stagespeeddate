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
                $short_bio = '';
                $available = false;
                //create a 'bio' with 50 to 100 random giberish 'words'
                for ($x=0; $x < rand(50, 100); $x++) { 
                    $bio = $bio . ' ' . str::random(rand(1,7));
                }
                //create a short 'bio' with 20 to 40 random giberish 'words'
                for ($x=0; $x < rand(20, 40); $x++) { 
                    $short_bio = $short_bio . ' ' . str::random(rand(1,7));
                }
                /* random assign availability*/
                if(rand(1,70) > 25){
                    $available = true;
                }
                Vacancy::factory()->create([
                    'company_id' => $companyId,
                    'name' => 'Stage '.$i/* str::random(8) */,
                    'short_bio' => $short_bio,
                    'bio' => $bio /* str::random(90) */,
                    'available' => $available,
                ]);
            }    
            
        }
    }
}
