<?php

namespace App\Services;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Plan;

interface PlanService
{
    public function getPaginatedPlans(int $perPage): LengthAwarePaginator;

    public function getPlanDetails(Plan $plan): Plan;
}
