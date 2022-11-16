<?php

namespace Database\Seeders;

use App\Models\AccountType;
use App\Models\User;
use App\Models\Funct;
use App\Models\Office;
use App\Models\ScoreEq;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        Office::factory()->create([
            'office' => 'HRMO',
            'building' => 'Administration Bldg.'
        ]);
        Office::factory()->create([
            'office' => 'PMO',
            'building' => 'Administration Bldg.'
        ]);
        Office::factory(5)->create();
        AccountType::factory()->create([
            'account_type' => 'Designated Faculty',
            'rank' => 3
        ]);
        AccountType::factory()->create([
            'account_type' => 'Staff',
            'rank' => 4
        ]);
        AccountType::factory()->create([
            'account_type' => 'Head of Office',
            'rank' => 2
        ]);
        AccountType::factory()->create([
            'account_type' => 'Head of Delivery Unit',
            'rank' => 2
        ]);
        AccountType::factory()->create([
            'account_type' => 'Head of Agency',
            'rank' => 1
        ]);
        AccountType::factory()->create([
            'account_type' => 'Not Designated Faculty',
            'rank' => 4
        ]);
        Funct::factory()->create([
            'funct' => 'Core Function'
        ]);
        Funct::factory()->create([
            'funct' => 'Strategic Function'
        ]);
        Funct::factory()->create([
            'funct' => 'Support Function'
        ]);
        ScoreEq::factory(1)->create();
        $this->call([
            UserSeeder::class
        ]);
    }
}
