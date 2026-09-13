<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\MovieService;


class MovieList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render(MovieService $movieService)
    {
        return view('livewire.movie-list', [
            'movies' => $movieService->getMovies($this->search)
        ]);
    }
}
