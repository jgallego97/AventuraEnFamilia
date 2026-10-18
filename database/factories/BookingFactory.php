<?php

namespace Database\Factories;

use App\Models\Departure;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'departure_id' => Departure::factory(),
            'spots' => 1,
            'total_price' => '0.00',
            'status' => 'pending',
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'confirmed']);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'cancelled']);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => ['status' => 'rejected']);
    }
}
