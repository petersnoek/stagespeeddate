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
                'name' => 'Big Corp.'/* str::random(8) */,
                'email' => 'Compmail'.$userId.'@example.com',
                'bio' => str::random(30),
                'user_id' => $userId,
            ]);
        }
    }
}
