<?php

namespace Tests\Feature\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Repositories\RatingRepository;
use App\Models\User;
use App\Models\Movie;

class RatingRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private RatingRepository $ratingRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ratingRepository = $this->app->make(RatingRepository::class);
    }

    public function test_service_container_not_null()
    {
        $this->assertNotNull($this->ratingRepository);
    }

    public function test_rate_movie_creates_new_rating()
    {
        $userId = User::factory()->create()->id;
        $movieId = Movie::factory()->create()->id;
        $ratingValue = 4;

        $rating = $this->ratingRepository->rateMovie(
            ['user_id' => $userId, 'movie_id' => $movieId],
            ['rating' => $ratingValue]
        );

        $this->assertDatabaseHas('ratings', [
            'user_id' => $userId,
            'movie_id' => $movieId,
            'rating' => $ratingValue,
        ]);

        $this->assertEquals($ratingValue, $rating->rating);
    }

    public function test_get_rating_movie_by_user_returns_correct_rating()
    {
        $userId = User::factory()->create()->id;
        $movieId = Movie::factory()->create()->id;
        $ratingValue = 5;

        $this->ratingRepository->rateMovie(
            ['user_id' => $userId, 'movie_id' => $movieId],
            ['rating' => $ratingValue]
        );

        $retrievedRating = $this->ratingRepository->getRatingMovieByUser($userId, $movieId);

        $this->assertNotNull($retrievedRating);
        $this->assertEquals($ratingValue, $retrievedRating->rating);
    }
}
