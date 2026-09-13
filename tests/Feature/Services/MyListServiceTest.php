<?php

namespace Tests\Feature\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\MyListService;
use App\Models\Movie;
use App\Models\User;

class MyListServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private MyListService $myListService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->myListService = $this->app->make(MyListService::class);
    }

    public function test_service_container_not_null()
    {
        $this->assertNotNull($this->myListService);
    }

    public function test_add_movie_to_my_list()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        $myList = $this->myListService->addMovieToMyList($user, $movie);

        $this->assertDatabaseHas('my_lists', [
            'id' => $myList->id,
            'user_id' => $user->id,
            'movie_id' => $movie->id,
        ]);
    }

    public function test_get_all_my_list()
    {
        $user = User::factory()->create();
        $movie1 = Movie::factory()->create(['title' => 'Movie 1']);
        $movie2 = Movie::factory()->create(['title' => 'Movie 2']);
        $movie3 = Movie::factory()->create(['title' => 'Another Movie']);

        $user->myLists()->createMany([
            ['movie_id' => $movie1->id],
            ['movie_id' => $movie2->id],
            ['movie_id' => $movie3->id],
        ]);

        $perPage = 2;
        $searchTerm = 'Movie';
        $myLists = $this->myListService->getAllMyList($user, $perPage, $searchTerm);

        $this->assertCount(2, $myLists);
        foreach ($myLists as $myList) {
            $this->assertStringContainsString($searchTerm, $myList->movie->title);
        }
    }

    public function test_remove_movie_from_my_list()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        $myList = $this->myListService->addMovieToMyList($user, $movie);

        $result = $this->myListService->removeMovieFromMyList($myList);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('my_lists', [
            'id' => $myList->id,
            'user_id' => $user->id,
            'movie_id' => $movie->id,
        ]);
    }
}
