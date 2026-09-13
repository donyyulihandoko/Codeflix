<?php

namespace App\Livewire;

use App\Services\MyListService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MyListMovies extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render(MyListService $myListService)
    {
        return view('livewire.my-list-movies', [
            'myLists' => $myListService->getAllMyList(Auth::user(), 12, $this->search)
        ]);
    }
}
