<?php

namespace App\Repositories;

use App\Models\Plan;
// use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface PlanRepository
{
    public function getPaginatedPlans(int $perPage): LengthAwarePaginator;

    public function getPlanDetails(Plan $plan): Plan;
}
