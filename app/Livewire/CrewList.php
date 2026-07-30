<?php

namespace App\Livewire;

use App\Services\CrewService;
use Livewire\Component;
use Livewire\WithPagination;

class CrewList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render(CrewService $crewService)
    {
        return view('livewire.crew-list', [
            'crews' => $crewService->getAllCrews($this->search)
        ]);
    }
}
