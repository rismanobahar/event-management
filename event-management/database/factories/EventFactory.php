<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->sentence(3), // Unique name for the event
            'description' => fake()->text, // Description of the event
            'start_time' => fake()->dateTimeBetween('now', '+1 month'), // Start time of the event
            'end_time' => fake()->dateTimeBetween('+1 month', '+2 months'), // End time of the event
        ];
    }
}
