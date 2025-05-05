<?php

namespace Database\Factories;

use App\Models\Competition;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str;

class CompetitionFactory extends Factory
{
    protected $model = Competition::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'category' => 'Teknologi',
            'prize' => 'Rp 5.000.000',
            'deadline' => now()->addDays(7),
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(8),
            'registration_link' => 'https://example.com/register',
            'location' => 'Online',
            'organizer_id' => User::factory(),
        ];
    }
}
