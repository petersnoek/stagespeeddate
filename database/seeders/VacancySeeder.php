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

        foreach($companyIds as $company_id){
            for ($i=1; $i < 6; $i++) { 
                $bio = '';
                $description = '';
                $available = false;
                //create a short 'bio' with 20 to 40 random giberish 'words'
                for ($x=0; $x < rand(20, 40); $x++) { 
                    $bio = $bio . ' ' . str::random(rand(1,7));
                }
                //create a 'description' with 50 to 100 random giberish 'words'
                for ($x=0; $x < rand(50, 100); $x++) { 
                    $description = $description . ' ' . str::random(rand(1,7));
                }
                
                /* random assign availability*/
                if(rand(1,70) > 25){
                    $available = true;
                }

                $niveau = 0;
                
                Vacancy::factory()->create([
                    'company_id' => $company_id,
                    'name' => Company::where('id',$company_id)->first()->name . ' Stage '.$i/* str::random(8) */,
                    'niveau' => $niveau,
                    'bio' => $bio,
                    'description' => $description /* str::random(90) */,
                    'available' => $available,
                ]);
            }    
            
        }
    }
}
