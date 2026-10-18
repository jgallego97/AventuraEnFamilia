<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Guide;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DepartureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'activity_id' => Activity::factory(),
            'guide_id' => null,
            'starts_at' => Carbon::instance(fake()->dateTimeBetween('2026-11-01', '2027-03-31'))->setTime(9, 0),
            'price' => fake()->randomFloat(2, 10, 60),
            'capacity' => fake()->numberBetween(8, 25),
            'status' => 'open',
        ];
    }

    public function withGuide(): static
    {
        return $this->state(fn (array $attributes) => [
            'guide_id' => Guide::factory(),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'guide_id' => Guide::factory(),
            'starts_at' => Carbon::instance(fake()->dateTimeBetween('2026-05-01', '2026-09-30'))->setTime(9, 0),
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_progress',
            'guide_id' => Guide::factory(),
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
}
