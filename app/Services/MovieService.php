<?php

namespace App\Services;
use App\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Category;
interface MovieService
{
    // dashboard controller
    public function getHeroMovie(): ?Movie;

    public function getTredingMovies(int $limit = 6): Collection;

    public function getTopRateMovies(int $limit = 6): Collection;

    public function getContinueWatching(int $limit = 6): Collection;

    public function getNewReleaseMovies(int $limit = 6): Collection;


    // movie controller
    public function getMovies(?string $search = null): LengthAwarePaginator;

    public function showMovie(Movie $movie): Movie;

    public function watchMovie(Movie $movie): Movie;

    public function getMoviesByCategory(Category $category, ?string $search = null): LengthAwarePaginator;
}
