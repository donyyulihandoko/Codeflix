<?php

namespace Tests\Feature\Services;

use App\Services\PlanService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Plan;
use Override;

class PlanServiceTest extends TestCase
{
    use RefreshDatabase;

    private PlanService $planService;

    #[Override]
    protected  function setUp(): void
    {
        parent::setUp();
        $this->planService = $this->app->make(planService::class);
    }

    public function test_service_container_not_null(): void
    {
        $this->assertNotNull($this->planService);
    }

    public function test_get_paginated_plans(): void
    {
        Plan::factory(10)->create();
        $result = $this->planService->getPaginatedPlans(6);
        $this->assertNotNull($result);
        $this->assertCount(6, $result);
        $this->assertEquals(10, $result->total());
    }

    public function test_get_plan_details()
    {
        $plan = Plan::factory()->create();
        $result = $this->planService->getPlanDetails($plan);
        $this->assertNotNull($result);
        $this->assertEquals($plan->title, $result->title);
    }

    public function test_get_plan_by_name(): void
    {
        Plan::factory(5)->create();
        $result = $this->planService->getPlanByName();
        $this->assertNotNull($result);
        $this->assertCount(5, $result);
    }

}
