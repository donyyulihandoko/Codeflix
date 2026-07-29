<?php

namespace App\Services\Impl;

use App\Services\MovieService;
use Override;
use App\Models\Movie;
use App\Repositories\MovieRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class MovieServiceImpl implements MovieService
{

    public function __construct(private MovieRepository $movieRepository)
    {
        //
    }

    #[Override]
    public function getHeroMovie(): ?Movie
    {
        return $this->movieRepository->getHeroMovie();
    }

    #[Override]
    public function getTredingMovies(int $limit): Collection
    {
        return $this->movieRepository->getTrendingMovies($limit);
    }

    public function getTopRateMovies(int $limit): Collection
    {
        return $this->movieRepository->getTopRateMovies($limit);
    }

    #[Override]
    public function getContinueWatching(int $limit): Collection
    {
            return $this->movieRepository->getContinueWatching($limit);
    }

    #[Override]
    public function getNewReleaseMovies(int $limit): Collection
    {
        return $this->movieRepository->getNewReleaseMovies($limit);
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
