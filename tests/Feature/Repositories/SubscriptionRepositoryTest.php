<?php

namespace Tests\Feature\Repositories;

use App\Models\Plan;
use App\Models\User;
use App\Repositories\SubscriptionRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Override;

class SubscriptionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private SubscriptionRepository $subscriptionRepository;

    #[Override]
    protected  function setUp(): void
    {
        parent::setUp();
        $this->subscriptionRepository = $this->app->make(SubscriptionRepository::class);
    }

    public function test_service_container_not_null(): void
    {
        $this->assertNotNull($this->subscriptionRepository);
    }

    public function test_create(): void
    {
        $user = User::factory()->is_member1()->create();
        $plan = Plan::factory()->create();

        $data = [
            'plan_id' => $user->id,
            'user_id'=> $plan->id,
            'active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
        ];

        $this->subscriptionRepository->create($data);

        $this->assertDatabaseHas('subscriptions', [
            'plan_id' => $plan->id,
            'user_id' => $user->id,
            'active' => true,
        ]);
    }

    public function test_get_current_subscription_plan(): void
    {
        $user = User::factory()->is_member1()->create();
        $plan = Plan::factory()->create();

        $subscription = $this->subscriptionRepository->create([
            'plan_id' => $plan->id,
            'user_id' => $user->id,
            'active' => true,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
        ]);

        $currentSubscription = $this->subscriptionRepository->getCurrentSubscriptionPlan($user->id);

        $this->assertNotNull($currentSubscription);
        $this->assertEquals($subscription->id, $currentSubscription->id);
    }

}
