<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Override;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Middleware\CheckDeviceSessionMiddleware;
use App\Models\Crew;
use Tests\TestCase;

class CrewControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->is_member1()->create());
        $this->withoutMiddleware(CheckDeviceSessionMiddleware::class);
    }

    public function test_index()
    {
        $response = $this->get(route('crews.index'));

        $response->assertOk()
            ->assertStatus(200);
    }

    public function test_show()
    {
        $crew = Crew::factory()->create();
        $response = $this->get(route('crews.show', $crew));

        $response->assertOk()
            ->assertStatus(200)
            ->assertViewIs('crews.show')
            ->assertViewHas('crew', $crew);
    }
}
