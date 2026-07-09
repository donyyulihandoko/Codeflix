<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends Factory<Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(),
            'director' => $this->faker->name(),
            'writers' => $this->faker->name(),
            'stars' => $this->faker->name(),
            'poster' => 'movies/dummy-poster.jpg',
            'release_date' => $this->faker->dateTimeThisDecade(), // Menghasilkan objek datetime yang valid
            'duration' => $this->faker->numberBetween(90, 180),
            // Mengikuti skema lama kamu: masing-masing kolom punya URL sendiri
            'url_720' => 'https://example.com/video-720p.mp4',
            'url_1080' => 'https://example.com/video-1080p.mp4',
            'url_4k' => 'https://example.com/video-4k.mp4',
        ];
    }
}
