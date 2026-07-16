<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\PlanService;
use Livewire\WithPagination;

class PlanList extends Component
{
    use WithPagination;

    public function render(PlanService $planService)
    {
        return view('livewire.plan-list', [
            'plans' => $planService->getPaginatedPlans(6)
        ]);
    }
}
