<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuideFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->guide(),
            'code' => fake()->unique()->numerify('GD-1###'),
        ];
    }
}
