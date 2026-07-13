<?php

namespace App\Services\Impl;

use App\Services\MovieService;
use Override;
use App\Models\Movie;
use App\Repositories\MovieRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieServiceImpl implements MovieService
{

    public function __construct(private MovieRepository $movieRepository)
    {
        //
    }

    #[Override]
    public function getHeroMovie()
    {
        return $this->movieRepository->getHeroMovie();
    }

    #[Override]
    public function getTredingMovies()
    {
        return $this->movieRepository->getTrendingMovies();
    }

    #[Override]
    public function getContinueWatching()
    {
        return $this->movieRepository->getContinueWatching();
    }

    // movie controller
    public function getMovies(?string $search = null): LengthAwarePaginator
    {
        return $this->movieRepository->getMovies($search);
    }

    #[Override]
    public function showMovie(Movie $movie): Movie
    {
        return $this->movieRepository->showMovie($movie);
    }

    #[Override]
    public function watchMovie(Movie $movie): Movie
    {
        return $this->movieRepository->watchMovie($movie);
    }
}
