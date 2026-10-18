<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => null,
            'password' => static::$password ??= Hash::make('password'),
            'phone' => fake()->numerify('6########'),
            'role' => 'customer',
        ];
    }

    public function withRole(string $role): static
    {
        return $this->state(fn (array $attributes) => ['role' => $role]);
    }

    public function guide(): static
    {
        return $this->withRole('guide');
    }
}
