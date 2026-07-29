<?php

namespace App\View\Components;

use App\Services\MovieService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewReleaseMovieList extends Component
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
        return view('components.new-release-movie-list', [
            'newReleaseMovies' => $this->movieService->getNewReleaseMovies(6)
        ]);
    }
}
