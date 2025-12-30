<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participant>
 */
class ParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'thread_id' => \App\Models\Thread::factory(),
            'user_id' => \App\Models\User::factory(),
            'last_read_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'deleted_at' => null,
        ];
    }
}
