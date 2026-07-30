<?php

namespace App\Services\Impl;

use App\Models\Plan;
use App\Repositories\PlanRepository;
use App\Services\PlanService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Override;

class PlanServiceImpl implements PlanService
{
    public function __construct(private PlanRepository $planRepository)
    {
        //
    }

    #[Override]
    public function getPaginatedPlans(int $perPage): LengthAwarePaginator
    {
        return $this->planRepository->getPaginatedPlans($perPage);
    }

    #[Override]
    public function getPlanDetails(Plan $plan): Plan
    {
        return $this->planRepository->getPlanDetails($plan);
    }

    public function getPlanByName()
    {
        return $this->planRepository->getPlanByName();
    }
}
