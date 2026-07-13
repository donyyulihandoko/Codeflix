<?php

namespace App\Livewire;

use App\Services\MovieService;
use Livewire\Component;
use Livewire\WithPagination;

class MovieCard extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render(MovieService $movieService)
    {
        return view('livewire.movie-card', [
            'movies' => $movieService->getMovies($this->search)
        ]);
    }
}
