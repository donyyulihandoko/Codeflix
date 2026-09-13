<?php

namespace Tests\Feature\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\RatingService;

class RatingServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private RatingService $ratingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ratingService = $this->app->make(RatingService::class);
    }

    public function test_service_container_not_null()
    {
        $this->assertNotNull($this->ratingService);
    }

    public function test_rate_movie_creates_new_rating()
    {
        $user = \App\Models\User::factory()->create();
        $movie = \App\Models\Movie::factory()->create();
        $ratingValue = 4;

        $rating = $this->ratingService->rateMovie($user, $movie, $ratingValue);

        $this->assertDatabaseHas('ratings', [
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'rating' => $ratingValue,
        ]);

        $this->assertEquals($ratingValue, $rating->rating);
    }

    public function test_get_rating_movie_by_user_returns_correct_rating()
    {
        $user = \App\Models\User::factory()->create();
        $movie = \App\Models\Movie::factory()->create();
        $ratingValue = 5;

        $this->ratingService->rateMovie($user, $movie, $ratingValue);

        $retrievedRating = $this->ratingService->getRatingMovieByUser($movie, $user);

        $this->assertNotNull($retrievedRating);
        $this->assertEquals($ratingValue, $retrievedRating->rating);
    }
}
