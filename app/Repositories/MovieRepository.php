<?php

namespace App\Repositories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface MovieRepository
{
    // dashboard controller
    public function getHeroMovie(): ?Movie ;

    public function getTrendingMovies(int $limit): Collection;

    public function getContinueWatching(int $limit): Collection;

    public function getTopRateMovies(int $limit): Collection;

    public function getNewReleaseMovies(int $limit): Collection;

    // movie controller

    public function getMovies(?string $search = null): LengthAwarePaginator;

    public function showMovie(Movie $movie): Movie;

    public function watchMovie(Movie $movie): Movie;

    public function getAverageRating(): ?int;
}
