<?php

namespace Tests\Feature\Services;

use App\Services\MovieService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;
use App\Models\Movie;
use Tests\TestCase;
use App\Models\User;
use App\Models\Rating;
use App\Models\Crew;
use App\Models\Category;

class MovieServiceTest extends TestCase
{
    use RefreshDatabase;

    private MovieService $movieService;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->movieService = $this->app->make(MovieService::class);
    }

    public function test_service_container_not_null(): void
    {
        $this->assertNotNull($this->movieService);
    }

    public function test_get_hero_movie(): void
    {
        Movie::factory()->create();
        $movie = $this->movieService->getHeroMovie();
        $this->assertNotNull($movie);
    }

    public function test_get_trending_movies(): void
    {
        Movie::factory(20)->create();
        $trendingMovies = $this->movieService->getTredingMovies(6);
        $this->assertNotNull($trendingMovies);
        $this->assertCount(6, $trendingMovies);
    }

    public function test_top_rate_movies(): void
    {
        $users = User::factory(5)->create();

        Movie::factory(20)->create()->each(function ($movie) use ($users) {
            foreach ($users as $user) {
                Rating::factory()->create([
                    'movie_id' => $movie->id,
                    'user_id' => $user->id,
                ]);
            }
        });

        $topRateMovies = $this->movieService->getTopRateMovies(6);

        $this->assertNotNull($topRateMovies);
        $this->assertCount(6, $topRateMovies);
    }

    public function test_continue_watching_movies(): void
    {
        Movie::factory(20)->create();
        $continueWatchingMovies = $this->movieService->getContinueWatching(6);

        $this->assertNotNull($continueWatchingMovies);
        $this->assertCount(6, $continueWatchingMovies);
    }

    public function test_new_release_movies(): void
    {
        Movie::factory(20)->create();
        $newReleaseMovies = $this->movieService->getNewReleaseMovies(6);

        $this->assertNotNull($newReleaseMovies);
        $this->assertCount(6, $newReleaseMovies);
    }

    public function test_get_movies_pagination(): void
    {
        Movie::factory(20)->create();
        $movies = $this->movieService->getMovies();
        $this->assertNotNull($movies);
        $this->assertCount(18, $movies);
    }

    public function test_get_movies_by_search_by_title(): void
    {
        Movie::factory()->create(['title' => 'The Matrix']);
        Movie::factory()->create(['title' => 'Inception']);

        $moviesBySearch = $this->movieService->getMovies('Matrix');

        $this->assertNotNull($moviesBySearch);
        $this->assertCount(1, $moviesBySearch);
        $this->assertEquals('The Matrix', $moviesBySearch->first()->title);
    }

    public function test_get_movies_by_writers(): void
    {
        // 1. Buat data Crew (sebagai writer)
        $writer = Crew::factory()->create(['name' => 'Christopher Nolan']);

        // 2. Buat movie dan hubungkan ke writer lewat pivot 'writer_movie'
        $movie = Movie::factory()->create();
        $movie->writers()->attach($writer->id);

        $moviesBySearch = $this->movieService->getMovies('Christopher Nolan');

        $this->assertNotNull($moviesBySearch);
        $this->assertCount(1, $moviesBySearch);
        $this->assertEquals($movie->id, $moviesBySearch->first()->id);
    }

    public function test_get_movies_by_directors(): void
    {
        // 1. Buat data Crew (sebagai director)
        $director = Crew::factory()->create(['name' => 'Christopher Nolan']);

        // 2. Buat movie dan hubungkan ke director lewat pivot 'director_movie'
        $movie = Movie::factory()->create();
        $movie->directors()->attach($director->id);

        $moviesBySearch = $this->movieService->getMovies('Christopher Nolan');

        $this->assertNotNull($moviesBySearch);
        $this->assertCount(1, $moviesBySearch);
        $this->assertEquals($movie->id, $moviesBySearch->first()->id);
    }

    public function test_get_movies_by_stars(): void
    {
        // 1. Buat data Crew (sebagai star)
        $star = Crew::factory()->create(['name' => 'Leonardo DiCaprio']);

        // 2. Buat movie dan hubungkan ke star lewat pivot 'star_movie'
        $movie = Movie::factory()->create();
        $movie->stars()->attach($star->id);

        $moviesBySearch = $this->movieService->getMovies('Leonardo DiCaprio');

        $this->assertNotNull($moviesBySearch);
        $this->assertCount(1, $moviesBySearch);
        $this->assertEquals($movie->id, $moviesBySearch->first()->id);
    }

    public function test_show_movies(): void
    {
        $movie = Movie::factory()->create();
        $result = $this->movieService->showMovie($movie);
        $this->assertNotNull($result);
        $this->assertEquals($result->id, $movie->id);
    }

    public function test_watch_movies(): void
    {
        $movie = Movie::factory()->create();
        $result = $this->movieService->watchMovie($movie);
        $this->assertNotNull($result);
        $this->assertEquals($result->id, $movie->id);
    }

     public function test_get_movies_by_category(): void
    {
        // 1. Buat data Category
        $category = Category::factory()->create(['title' => 'Action']);

        // 2. Buat movie dan hubungkan ke category lewat pivot 'category_movie'
        $movie = Movie::factory()->create();
        $movie->categories()->attach($category->id);

        $moviesByCategory = $this->movieService->getMoviesByCategory($category);

        $this->assertNotNull($moviesByCategory);
        $this->assertCount(1, $moviesByCategory);
        $this->assertEquals($movie->id, $moviesByCategory->first()->id);
    }


}
