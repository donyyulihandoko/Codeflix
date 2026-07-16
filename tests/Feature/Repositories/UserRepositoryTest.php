<?php

namespace Tests\Feature\Repositories;

use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Override;
use App\Models\User;
use App\Models\Subscription;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private UserRepository $userRepository;

    #[Override]
    protected  function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->app->make(UserRepository::class);
    }

    public function test_service_container_not_null(): void
    {
        $this->assertNotNull($this->userRepository);
    }

    public function test_has_subscription_plan(): void
    {
        $user = User::factory()->is_member1()->create();
        Subscription::factory()->create([
            'user_id' => $user->id
        ]);

        $result = $this->userRepository->hassubscriptionPlan($user->id);

        $this->assertTrue($result);
    }

    public function test_does_not_have_subscription_plan(): void
    {
        $user = User::factory()->is_member1()->create();

        $result = $this->userRepository->hassubscriptionPlan($user->id);

        $this->assertFalse($result);
    }
}
