<?php

namespace Tests\Feature\Services;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Override;
use App\Models\User;
use App\Models\Subscription;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    private UserService $userService;

    #[Override]
    protected  function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
    }

    public function test_service_container_not_null(): void
    {
        $this->assertNotNull($this->userService);
    }

    public function test_has_subscription_plan(): void
    {
        $user = User::factory()->is_member1()->create();
        Subscription::factory()->create([
            'user_id' => $user->id
        ]);

        $result = $this->userService->hassubscriptionPlan($user->id);

        $this->assertTrue($result);
    }

    public function test_does_not_have_subscription_plan(): void
    {
        $user = User::factory()->is_member1()->create();

        $result = $this->userService->hassubscriptionPlan($user->id);

        $this->assertFalse($result);
    }
}
