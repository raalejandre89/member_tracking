<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $team = Team::factory()->create();

        return [
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'city' => fake()->city(),
            'state' => fake()->text(10),
            'country' => fake()->country(),
            'team_id' => $team->id,
        ];
    }
}
