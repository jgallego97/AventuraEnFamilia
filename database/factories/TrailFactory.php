<?php

namespace Database\Factories;

use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrailFactory extends Factory
{
    public function definition(): array
    {
        $distance = fake()->randomFloat(2, 2, 18);
        $ascent = fake()->numberBetween(50, 1200);
        $descent = max(0, $ascent + fake()->numberBetween(-60, 60));

        $difficulty = match (true) {
            $distance < 8 && $ascent < 300 => 'easy',
            $distance < 14 && $ascent < 700 => 'moderate',
            default => 'hard',
        };

        return [
            'name' => 'Sendero ' . fake()->unique()->lastName(),
            'distance_km' => $distance,
            'ascent_m' => $ascent,
            'descent_m' => $descent,
            'difficulty' => $difficulty,
            'zone_id' => Zone::factory(),
        ];
    }
}
