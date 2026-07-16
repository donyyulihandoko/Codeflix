<?php

namespace App\Services;
use App\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;
interface MovieService
{
    // dashboard controller
    public function getHeroMovie(): ?Movie;

    // public function getContinueWatching() : LengthAwarePaginator;

    public function getTredingMovies(): LengthAwarePaginator;

    // movie controller
    public function getMovies(?string $search = null): LengthAwarePaginator;

    public function showMovie(Movie $movie): Movie;

    public function watchMovie(Movie $movie): Movie;
}
