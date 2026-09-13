<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
use App\Http\Middleware\CheckDeviceSessionMiddleware;

class SubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(CheckDeviceSessionMiddleware::class);
        $this->actingAs(User::factory()->is_member1()->create());
    }

    public function test_index_returns_successful_response(): void
    {
        $this->get(route('subscriptions.index'))
            ->assertStatus(200);
    }

    public function test_show_returns_successful_response(): void
    {
        $plan = \App\Models\Plan::factory()->create();

        $response = $this->get(route('subscriptions.show', $plan));

        $response->assertStatus(200);
    }
}
