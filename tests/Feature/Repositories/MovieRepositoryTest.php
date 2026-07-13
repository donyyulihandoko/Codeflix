<?php

namespace Tests\Feature\Repositories;

use App\Repositories\MovieRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use App\Models\Movie;
use Tests\TestCase;

class MovieRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private MovieRepository $movieRepository;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->movieRepository = $this->app->make(MovieRepository::class);
    }

    public function test_service_container_not_null(): void
    {
        $this->assertNotNull($this->movieRepository);
    }

    public function test_get_hero_movie(): void
    {
        Movie::factory()->create();
        $movie = $this->movieRepository->getHeroMovie();
        $this->assertNotNull($movie);
    }

    public function test_get_trending_movies(): void
    {
        Movie::factory(20)->create();
        $trendingMovies = $this->movieRepository->getTrendingMovies();
        $this->assertNotNull($trendingMovies);
        $this->assertCount(6, $trendingMovies);
        $this->assertEquals(20, $trendingMovies->total());
    }

    public function test_show_movies(): void
    {
        $movie = Movie::factory()->create();
        $result = $this->movieRepository->showMovie($movie);
        $this->assertNotNull($result);
        $this->assertEquals($result->id, $movie->id);
    }

    public function test_watch_movies(): void
    {
        $movie = Movie::factory()->create();
        $result = $this->movieRepository->watchMovie($movie);
        $this->assertNotNull($result);
        $this->assertEquals($result->id, $movie->id);
    }



}
