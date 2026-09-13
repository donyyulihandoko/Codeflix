<?php

namespace Tests\Feature\Controllers;

use App\Http\Middleware\CheckDeviceSessionMiddleware;
use App\Models\Movie;
use App\Models\User;
// use App\Services\RatingService;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use Mockery\MockInterface;
use Override;
use Tests\TestCase;
use Mockery;

class RatingControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $plan = Plan::factory()->create(['max_devices' => 5]);

        Subscription::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'active' => true
        ]);

        $this->actingAs($user);
        $this->withoutMiddleware(CheckDeviceSessionMiddleware::class);
    }

    public function test_store_rates_movie_successfully_and_redirects_back(): void
    {

        // 1. Arrange
        $movie = Movie::factory()->create();
        $payload = ['rating' => 5];


        // 2. Act: Kirim request POST ke endpoint store dengan HTTP Referer agar back() terdeteksi
        $response = $this->from(route('movies.show', $movie))
            ->post(route('ratings.store', $movie), $payload);

        // 3. Assert
        $response->assertRedirectBack()
            ->assertSessionHas('success', 'Thanks for rating this movie!');
    }

    public function test_store_fails_validation_when_rating_is_missing_or_invalid(): void
    {
        // 1. Arrange
        $movie = Movie::factory()->create();
        $invalidPayload = ['rating' => 10]; // Asumsi rating maksimal 5 pada Form Request

        // 2. Act
        $response = $this->from(route('movies.show', $movie))
            ->post(route('ratings.store', $movie), $invalidPayload);

        // 3. Assert
        $response->assertRedirect(route('movies.show', $movie))
            ->assertSessionHasErrors(['rating']);
    }
}
