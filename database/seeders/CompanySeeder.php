<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::where('role','company')->pluck('id')->toArray();

        $bio = '';
        $description = '';
        foreach($userIds as $userId){    
            //create a short 'bio' with 40 to 60 random giberish 'words'
            for ($x=0; $x < rand(40, 60); $x++) { 
                $bio = $bio . ' ' . str::random(rand(1,7));
            }
            //create a 'description' with 100 to 300 random giberish 'words'
            for ($x=0; $x < rand(100, 300); $x++) { 
                $description = $description . ' ' . str::random(rand(1,7));
            }
            Company::factory()->create([
                'name' => 'Big Corp ' . str::random(2),
                'bio' => 'This is an example of a company bio, this is test data don\'t think too much about it',
                'description' => /* str::random(250) */ $description,
                'location' => 'Mollenburgseweg 82, 4205 NB Gorinchem',
                'user_id' => $userId,
                'image' => 'media/photos/photo' . random_int(1, 37) . '.jpg',
            ]);
        }

        Company::factory()->create([
            'name' => 'Xlab Cloud Services B.V.',
            'bio' => 'Ontwikkelen, produceren en uitgeven van software.',
            'description' => str::random(250),
            'location' => 'Computerweg 11, 3542 DP Utrecht',
            'user_id' => '110',
            'image' => 'media/photos/xlab.jpg',
        ]);

        Company::factory()->create([
            'name' => 'Koen Pack B.V.',
            'bio' => 'Groothandel in emballage.',
            'description' => str::random(250),
            'location' => 'De Loetenweg 8, 1187 WB Amstelveen',
            'user_id' => '120',
            'image' => 'media/photos/koen.jpg',
        ]);

        Company::factory()->create([
            'name' => 'MKB Voice',
            'bio' => 'Reclamebureaus',
            'description' => str::random(250),
            'location' => 'Minervum 7162 A, 4817 ZN Breda',
            'user_id' => '130',
            'image' => 'media/photos/mkb.jpg',
        ]);

        Company::factory()->create([
            'name' => 'COERS Online branding',
            'bio' => 'Ontwikkelen, produceren en uitgeven van software.',
            'description' => str::random(250),
            'location' => 'Emmaplein 2 Y, 5211 VW \'s-Hertogenbosch',
            'user_id' => '140',
            'image' => 'media/photos/coers.jpg',
        ]);

        Company::factory()->create([
            'name' => 'Movella',
            'bio' => 'Groothandel in elektronische en telecommunicatieapparatuur en bijbehorende onderdelen.',
            'description' => str::random(250),
            'location' => 'Pantheon 6 a, 7521 PR Enschede',
            'user_id' => '150',
            'image' => 'media/photos/movella.jpg',
        ]);

        //sleep 1 second and update updated_at timestamp for created_at and updated_at needing to be different to be displayed on dashboard
        sleep(1);
        foreach(Company::all() as $company){
            $company->updated_at = now();
            $company->save();
        }
    }
}
