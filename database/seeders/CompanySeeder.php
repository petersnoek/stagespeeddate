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

        foreach($userIds as $userId){    
            Company::factory()->create([
                'name' => 'Big Corp ' . str::random(2),
                'bio' => 'This is an example of a company bio, this is test data don\'t think too much about it',
                'description' => str::random(250),
                'user_id' => $userId,
                'image' => 'media/photos/photo' . random_int(1, 37) . '.jpg',
            ]);
        }

        Company::factory()->create([
            'name' => 'Xlab Cloud Services B.V.',
            'bio' => 'Ontwikkelen, produceren en uitgeven van software.',
            'description' => str::random(250),
            'user_id' => '11',
            'image' => 'media/photos/xlab.jpg',
        ]);

        Company::factory()->create([
            'name' => 'Koen Pack B.V.',
            'bio' => 'Groothandel in emballage.',
            'description' => str::random(250),
            'user_id' => '12',
            'image' => 'media/photos/koen.jpg',
        ]);

        Company::factory()->create([
            'name' => 'MKB Voice',
            'bio' => 'Reclamebureaus',
            'description' => str::random(250),
            'user_id' => '13',
            'image' => 'media/photos/mkb.jpg',
        ]);

        Company::factory()->create([
            'name' => 'COERS Online branding',
            'bio' => 'Ontwikkelen, produceren en uitgeven van software.',
            'description' => str::random(250),
            'user_id' => '14',
            'image' => 'media/photos/coers.jpg',
        ]);

        Company::factory()->create([
            'name' => 'Movella',
            'bio' => 'Groothandel in elektronische en telecommunicatieapparatuur en bijbehorende onderdelen.',
            'description' => str::random(250),
            'user_id' => '15',
            'image' => 'media/photos/movella.jpg',
        ]);
    }
}
