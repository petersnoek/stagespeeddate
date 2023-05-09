<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = \App\Models\User::where('role','company')->pluck('id')->toArray();

        foreach($userIds as $userId){    
            \App\Models\Company::factory()->create([
                'name' => str::random(8),
                'bio' => str::random(30),
                'user_id' => $userId,
            ]);
        }
    }
}
