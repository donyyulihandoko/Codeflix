<?php

namespace App\Repositories;

use App\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;

interface MovieRepository
{
    // dashboard controller
    public function getHeroMovie(): ?Movie ;

    public function getTrendingMovies(): LengthAwarePaginator;

    // public function getContinueWatching(): LengthAwarePaginator;

    // movie controller

    public function getMovies(?string $search = null): LengthAwarePaginator;

    public function showMovie(Movie $movie): Movie;

    public function watchMovie(Movie $movie): Movie;


}
