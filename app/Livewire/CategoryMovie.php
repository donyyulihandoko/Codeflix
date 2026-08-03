<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\MovieService;

class CategoryMovie extends Component
{
    use WithPagination;

    public $search = '';
    public Category $category;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render(MovieService $movieService)
    {
        return view('livewire.category-movie', [
            'movies' => $movieService->getMoviesByCategory($this->category, $this->search)
        ]);
    }
}
