<?php

namespace App\Repositories;

use App\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;

interface MovieRepository
{
    // dashboard controller
    public function getHeroMovie();

    public function getTrendingMovies();

    public function getContinueWatching();

    // movie controller

    public function getMovies(?string $search = null): LengthAwarePaginator;

    public function showMovie(Movie $movie): Movie;

    public function watchMovie(Movie $movie): Movie;


}
