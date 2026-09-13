<?php

namespace Database\Factories;

use App\Models\Crew;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Crew>
 */
class CrewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'birth_date' => $this->faker->date('Y-m-d', '2000-01-01'), // Tanggal lahir acak sebelum tahun 2000
            'place_of_birth' => $this->faker->city() . ', ' . $this->faker->country(),
            'biography' => $this->faker->paragraph(3), // Tetap pakai teks acak untuk biografi panjang
            'photo' => fake()->imageUrl(),
        ];
    }
}
