<?php

namespace App\Repositories\Impl;

use App\Repositories\MovieRepository;
use Override;
use App\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieRepositoryImpl implements MovieRepository
{

    // dashboard controller
    #[Override]
    public function getHeroMovie(): ?Movie
    {
        return Movie::query()
            ->latest()
            ->first();
    }

    #[Override]
    public function getTrendingMovies(): LengthAwarePaginator
    {
        return Movie::query()
            ->latest()
            ->paginate(6);
    }

    // #[Override]
    // public function getContinueWatching(): LengthAwarePaginator
    // {
    //     //
    // }

    // movie controller

    #[Override]
    public function getMovies(?string $search = null): LengthAwarePaginator
    {
        return Movie::query()
            ->when($search, function($query, $search) {
                    return $query->where('title', 'like', "%{$search}%");
            })->latest()
                ->paginate(18)
                ->withQueryString();
    }

    #[Override]
    public function showMovie(Movie $movie): Movie
    {
        // return $movie;
        return $movie->load(['categories', 'writers', 'directors', 'stars']);
    }

    #[Override]
    public function watchMovie(Movie $movie): Movie
    {
        return $movie;
    }

}
