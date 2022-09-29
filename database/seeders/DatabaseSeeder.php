<?php

namespace Database\Seeders;

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
