<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faction>
 */
class FactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'system_id' => 0,
            'name' => $this->faker->word(),
            'allegiance' => $this->faker->randomElement(['Alliance', 'Empire', 'Federation', 'Independent']),
            'government' => $this->faker->randomElement(['Anarchy', 'Communism', 'Confederacy', 'Cooperative', 'Corporate', 'Democracy', 'Dictatorship', 'Feudal', 'Imperial', 'Patronage', 'Prison Colony', 'Theocracy']),
            'influence' => $this->faker->randomFloat(2, 0, 100),
            'state' => $this->faker->randomElement(['Boom', 'Bust', 'Civil Unrest', 'Civil War', 'Expansion', 'Famine', 'Investment', 'Lockdown', 'Outbreak', 'Retreat', 'War']),
            'happiness' => $this->faker->randomElement(['Despondent', 'Unhappy', 'Discontented', 'Happy', 'Elated']),
            'active_states' => $this->faker->randomElement(['Boom', 'Bust', 'Civil Unrest', 'Civil War', 'Expansion', 'Famine', 'Investment', 'Lockdown', 'Outbreak', 'Retreat', 'War']),
            'pending_states' => $this->faker->randomElement(['Boom', 'Bust', 'Civil Unrest', 'Civil War', 'Expansion', 'Famine', 'Investment', 'Lockdown', 'Outbreak', 'Retreat', 'War']),
            'recovering_states' => $this->faker->randomElement(['Boom', 'Bust', 'Civil Unrest', 'Civil War', 'Expansion', 'Famine', 'Investment', 'Lockdown', 'Outbreak', 'Retreat', 'War']),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
