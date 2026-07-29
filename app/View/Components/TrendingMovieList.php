<?php

namespace App\View\Components;

use App\Services\MovieService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TrendingMovieList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(private MovieService $movieService)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.trending-movie-list', [
            'trendingMovie' => $this->movieService->getTredingMovies(6)
        ]);
    }
}
