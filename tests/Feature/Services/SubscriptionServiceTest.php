<?php

namespace Tests\Feature\Services;

use App\Models\Plan;
use App\Models\User;
use App\Services\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Override;

class SubscriptionServiceTest extends TestCase
{
    use RefreshDatabase;

    private SubscriptionService $subscriptionService;

    #[Override]
    protected  function setUp(): void
    {
        parent::setUp();
        $this->subscriptionService = $this->app->make(SubscriptionService::class);
    }

    public function test_service_container_not_null(): void
    {
        $this->assertNotNull($this->subscriptionService);
    }

    public function test_purchase_subscription(): void
    {
        $user = User::factory()->is_member1()->create();
        $plan = Plan::factory()->create();
        $this->subscriptionService->purchaseSubscription($user, $plan);

        $this->assertDatabaseHas('subscriptions', [
            'plan_id' => $plan->id,
            'user_id' => $user->id,
            'active' => true,
        ]);
    }

}
