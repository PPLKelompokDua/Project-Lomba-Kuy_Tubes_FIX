<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'leader_id' => User::factory(),
            'name' => $this->faker->company,
            'competition_id' => null,
            'competition_name' => $this->faker->words(3, true),
            'category' => 'General',
            'deadline' => now()->addDays(10),
            'location' => $this->faker->city,
            'description' => $this->faker->sentence,
            'status_team' => 'ongoing',
                    
        ];

    }
}
