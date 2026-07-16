<?php

namespace Tests\Feature\Repositories;

use App\Models\Plan;
use App\Repositories\PlanRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Override;
use Tests\TestCase;

class PlanRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private PlanRepository $planRepository;

    #[Override]
    protected  function setUp(): void
    {
        parent::setUp();
        $this->planRepository = $this->app->make(PlanRepository::class);
    }

    public function test_service_container_not_null(): void
    {
        $this->assertNotNull($this->planRepository);
    }

    public function test_get_paginated_plans(): void
    {
        Plan::factory(10)->create();
        $result = $this->planRepository->getPaginatedPlans(6);
        $this->assertNotNull($result);
        $this->assertCount(6, $result);
        $this->assertEquals(10, $result->total());
    }

    public function test_get_plan_details(): void
    {
        $plan = Plan::factory()->create();
        $result = $this->planRepository->getPlanDetails($plan);
        $this->assertNotNull($result);
        $this->assertEquals($plan->title, $result->title);
    }


}
