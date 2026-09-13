<?php

namespace Tests\Feature\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Repositories\MyListRepository;
use App\Models\Movie;
use App\Models\User;

class MyListRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private MyListRepository $myListRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->myListRepository = $this->app->make(MyListRepository::class);
    }

    public function test_service_container_not_null()
    {
        $this->assertNotNull($this->myListRepository);
    }

    public function test_create()
    {
        $data = [
            'user_id' => User::factory()->create()->id,
            'movie_id' => Movie::factory()->create()->id,
        ];

        $myList = $this->myListRepository->create($data);

        $this->assertDatabaseHas('my_lists', [
            'id' => $myList->id,
            'user_id' => 1,
            'movie_id' => 1,
        ]);
    }

    public function test_get_all_my_lists()
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
        $myLists = $this->myListRepository->getAllMyLists($user->id, $perPage, $searchTerm);

        $this->assertNotNull($myLists);
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $myLists);
        $this->assertCount(2, $myLists);
    }

    public function test_delete()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        $myList = $user->myLists()->create(['movie_id' => $movie->id]);

        $result = $this->myListRepository->delete($myList);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('my_lists', [
            'id' => $myList->id,
        ]);
    }
}
