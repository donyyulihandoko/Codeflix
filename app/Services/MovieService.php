<?php

namespace App\Services;
use App\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
interface MovieService
{
    // dashboard controller
    public function getHeroMovie(): ?Movie;

    public function getTredingMovies(int $limit): Collection;

    public function getTopRateMovies(int $limit): Collection;

    public function getContinueWatching(int $limit): Collection;

    public function getNewReleaseMovies(int $limit): Collection;


    // movie controller
    public function getMovies(?string $search = null): LengthAwarePaginator;

    public function showMovie(Movie $movie): Movie;

    public function watchMovie(Movie $movie): Movie;
}
