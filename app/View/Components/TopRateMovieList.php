<?php

namespace App\View\Components;

use App\Services\MovieService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TopRateMovieList extends Component
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
        return view('components.top-rate-movie-list', [
            'topRateMovies' => $this->movieService->getTopRateMovies(6)
        ]);
    }
}
