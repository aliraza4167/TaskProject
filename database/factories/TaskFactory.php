<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->realText(20),
            'description' => $this->faker->realText(100),
            'is_completed' => $this->faker->boolean,
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
