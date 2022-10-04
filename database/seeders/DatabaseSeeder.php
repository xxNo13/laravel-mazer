<?php

namespace Database\Seeders;

use App\Models\AccountType;
use App\Models\User;
use App\Models\Funct;
use App\Models\Office;
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
        Office::factory(5)->create();
        AccountType::factory()->create([
            'account_type' => 'Faculty'
        ]);
        AccountType::factory()->create([
            'account_type' => 'Staff'
        ]);
        AccountType::factory()->create([
            'account_type' => 'Head of Office'
        ]);
        AccountType::factory()->create([
            'account_type' => 'Head of Delivery Unit'
        ]);
        AccountType::factory()->create([
            'account_type' => 'Head of Agency'
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
        $this->call([
            UserSeeder::class
        ]);
    }
}
