<?php

namespace Tests\Feature\Services;

use App\Services\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Override;
use App\Models\User;
use App\Models\Plan;
use App\Models\Subscription;

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

    // public function test_purchase_subscription(): void
    // {
    //     $user = User::factory()->is_member1()->create();
    //     $plan = Plan::factory()->create();
    //     $this->subscriptionService->purchaseSubscription($user, $plan);

    //     $this->assertDatabaseHas('subscriptions', [
    //         'plan_id' => $plan->id,
    //         'user_id' => $user->id,
    //         'active' => true,
    //     ]);
    // }

    public function test_get_current_subscription_plan(): void
    {
        $user = User::factory()->is_member1()->create();
        $plan = Plan::factory()->create();

        Subscription::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'active' => true,
        ]);

        $currentSubscription = $this->subscriptionService->getCurrentSubscriptionPlan($user);

        $this->assertNotNull($currentSubscription);
        $this->assertEquals($plan->id, $currentSubscription->plan_id);
        $this->assertEquals($user->id, $currentSubscription->user_id);
        $this->assertTrue($currentSubscription->active);
    }

}
