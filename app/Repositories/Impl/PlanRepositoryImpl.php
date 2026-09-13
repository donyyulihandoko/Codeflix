<?php

namespace App\Repositories\Impl;

use App\Models\Plan;
// use Illuminate\Database\Eloquent\Collection;
use App\Repositories\PlanRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Override;

class PlanRepositoryImpl implements PlanRepository
{
    #[Override]
    public function getPaginatedPlans(int $perPage): LengthAwarePaginator
    {
        return Plan::query()
            ->select(['id', 'title', 'slug', 'price', 'duration', 'resolution', 'max_devices'])

            ->orderBy('price', 'asc')
            ->paginate($perPage);
    }

    #[Override]
    public function getPlanDetails(Plan $plan): Plan
    {
        return $plan;
    }

    #[Override]
    public function getPlanByName()
    {
        return Plan::query()
            ->get('title');
    }

}
