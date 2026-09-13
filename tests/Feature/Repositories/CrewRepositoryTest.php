<?php

namespace Tests\Feature\Repositories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Repositories\CrewRepository;
class CrewRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private CrewRepository $crewRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->crewRepository = $this->app->make(CrewRepository::class);
    }

    public function test_service_container_not_null()
    {
        $this->assertNotNull($this->crewRepository);
    }

    public function test_get_crew_with_movies()
    {
        $crew = \App\Models\Crew::factory()->create();
        $crewWithMovies = $this->crewRepository->getCrewWithMovies($crew);

        $this->assertNotNull($crewWithMovies);
        $this->assertInstanceOf(\App\Models\Crew::class, $crewWithMovies);
        $this->assertTrue($crewWithMovies->relationLoaded('directedMovies'));
        $this->assertTrue($crewWithMovies->relationLoaded('writtenMovies'));
        $this->assertTrue($crewWithMovies->relationLoaded('starredMovies'));
    }

    public function test_get_all_crews_with_search()
    {
        $crew1 = \App\Models\Crew::factory()->create(['name' => 'John Doe']);
        $crew2 = \App\Models\Crew::factory()->create(['name' => 'Jane Smith']);
        $crew3 = \App\Models\Crew::factory()->create(['name' => 'Alice Johnson']);

        $searchTerm = 'Jane';
        $crews = $this->crewRepository->getAllCrews($searchTerm);

        $this->assertNotNull($crews);
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $crews);
        $this->assertCount(1, $crews);
        $this->assertEquals('Jane Smith', $crews->first()->name);
    }
}
