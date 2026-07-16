<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends Factory<Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->word();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'price' => fake()->randomFloat(2, 0, 100),
            'duration' => 30,
            'resolution' => fake()->randomElement(['720p', '1080p', '4k']),
            'max_devices' => fake()->numberBetween(1, 5),
        ];
    }
}
