<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'birth_date' => fake()->dateTimeBetween('1956-01-01', '2008-05-01'),
            'national_id' => $this->nationalId(),
        ];
    }

    public function adult(): static
    {
        return $this->state(fn (array $attributes) => [
            'birth_date' => fake()->dateTimeBetween('1956-01-01', '2008-05-01'),
            'national_id' => $this->nationalId(),
        ]);
    }

    public function teen(): static
    {
        return $this->state(fn (array $attributes) => [
            'birth_date' => fake()->dateTimeBetween('2009-04-01', '2012-05-01'),
            'national_id' => $this->nationalId(),
        ]);
    }

    public function underFourteen(): static
    {
        return $this->state(fn (array $attributes) => [
            'birth_date' => fake()->dateTimeBetween('2013-04-01', '2022-04-30'),
            'national_id' => null,
        ]);
    }

    public function twelveOrUnder(): static
    {
        return $this->state(fn (array $attributes) => [
            'birth_date' => fake()->dateTimeBetween('2014-04-01', '2022-04-30'),
            'national_id' => null,
        ]);
    }

    /**
     * DNI válido: ocho cifras y la letra que corresponde al número
     * (el número módulo 23 indica la posición de la letra).
     */
    private function nationalId(): string
    {
        $number = fake()->unique()->numberBetween(10000000, 99999999);
        $letters = 'TRWAGMYFPDXBNJZSQVHLCKE';

        return $number . $letters[$number % 23];
    }
}
