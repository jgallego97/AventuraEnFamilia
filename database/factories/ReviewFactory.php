<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'rating' => fake()->randomElement([1, 2, 2, 3, 4, 4, 5, 5, 5]),
            'comment' => fake()->optional(0.6)->sentence(),
        ];
    }
}
