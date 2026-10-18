<?php

namespace Database\Factories;

use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => rtrim(fake()->unique()->sentence(3), '.'),
            'description' => fake()->paragraphs(2, true),
            'duration_min' => fake()->randomElement([60, 90, 120, 180, 240]),
            'min_age' => fake()->randomElement([0, 4, 12]),
            'active' => fake()->boolean(90),
            'zone_id' => Zone::factory(),
        ];
    }
}
