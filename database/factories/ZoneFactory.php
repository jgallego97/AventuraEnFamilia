<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ZoneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->city(),
            'province' => fake()->randomElement([
                'Ávila', 'Asturias', 'Granada', 'Barcelona',
                'Huesca', 'Madrid', 'Navarra', 'Segovia',
            ]),
        ];
    }
}
