<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScoreEq>
 */
class ScoreEqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'out_from' => 4,
            'out_to' => 5,
            'verysat_from' => 3,
            'verysat_to' => 3.99,
            'sat_from' => 2,
            'sat_to' => 2.99,
            'unsat_from' => 1,
            'unsat_to' => 1.99,
            'poor_from' => 0,
            'poor_to' => 0.99,
        ];
    }
}
