<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Override;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Middleware\CheckDeviceSessionMiddleware;
use App\Models\Movie;
use Tests\TestCase;
use App\Models\Plan;
use App\Models\Subscription;

class MovieControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->is_member1()->create());
        $this->withoutMiddleware([CheckDeviceSessionMiddleware::class]);
    }

    public function test_index()
    {
        $response = $this->get(route('movies.index'));
        $response->assertOk()
            ->assertStatus(200);
    }

    public function test_show()
    {
        $movie = Movie::factory()->create();
        $response = $this->get(route('movies.show', $movie));

        $response->assertOk()
            ->assertStatus(200)
            ->assertViewIs('movies.show')
            ->assertViewHas('movie', $movie);
    }

    public function test_watch(): void
    {
        // 1. Arrange: User, Plan, Subscription, dan Movie
        $user = User::factory()->create();
        $plan = Plan::factory()->create();

        Subscription::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
        ]);

        $movie = Movie::factory()->create();

        // 2. Act
        $response = $this->actingAs($user)->get(route('movies.watch', $movie));

        // 3. Assert
        $response->assertOk()
            ->assertViewIs('movies.watch')
            ->assertViewHas('movie', function ($viewMovie) use ($movie) {
                return $viewMovie->id === $movie->id;
            });
    }
}
