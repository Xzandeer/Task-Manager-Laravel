<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
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
        $dueDate = fake()->optional()->dateTimeBetween('today', '+1 month');

        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->optional()->paragraph(),
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed']),
            'due_date' => $dueDate?->format('Y-m-d'),
        ];
    }
}
