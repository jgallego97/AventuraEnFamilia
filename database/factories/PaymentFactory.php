<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'amount' => fake()->randomFloat(2, 10, 200),
            'method' => fake()->randomElement(Payment::METHODS),
            'status' => 'pending',
            'reference' => 'PAY-' . fake()->unique()->numerify('########'),
            'paid_at' => null,
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'paid_at' => fake()->dateTimeBetween('2026-01-01', '2026-10-01'),
        ]);
    }

    public function refunded(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'refunded',
            'paid_at' => fake()->dateTimeBetween('2026-01-01', '2026-10-01'),
        ]);
    }
}
