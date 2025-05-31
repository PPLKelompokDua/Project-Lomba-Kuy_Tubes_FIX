<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'profile_image' => 'default.jpg',
            'role' => 'user',
            'notification_preferences' => ['email', 'in_app'],
            'personality_type' => fake()->randomElement(['INTJ', 'ENFP', 'ISTJ', 'ENFJ']),
            'preferred_role' => fake()->randomElement(['Leader', 'Member', 'Specialist', 'Coordinator']),
            'experience' => [
                'competitions' => fake()->numberBetween(0, 10),
                'wins' => fake()->numberBetween(0, 5),
                'skills' => fake()->randomElements(['Programming', 'Design', 'Management', 'Research', 'Writing'], 2)
            ],
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}