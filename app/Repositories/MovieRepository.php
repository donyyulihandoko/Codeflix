<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface MovieRepository
{
    // dashboard controller
    public function getHeroMovie(): ?Movie ;

    public function getTrendingMovies(int $limit = 6): Collection;

    public function getContinueWatching(int $limit = 6): Collection;

    public function getTopRateMovies(int $limit = 6): Collection;

    public function getNewReleaseMovies(int $limit = 6): Collection;

    // movie controller

    public function getMovies(?string $search = null): LengthAwarePaginator;

    public function showMovie(Movie $movie): Movie;

    public function watchMovie(Movie $movie): Movie;

    // public function getAverageRating(): ?float;

    public function getMoviesByCategory(Category $category, ?string $search = null): LengthAwarePaginator;
}
