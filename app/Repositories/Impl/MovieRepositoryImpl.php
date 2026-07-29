<?php

namespace App\Repositories\Impl;

use App\Repositories\MovieRepository;
use Override;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
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
    public function getTrendingMovies(int $limit): Collection
    {
        return Movie::query()
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getTopRateMovies(int $limit): Collection
    {
        return Movie::query()
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->having('ratings_avg_rating', '>', 2)
            ->orderByDesc('ratings_avg_rating')
            ->orderByDesc('ratings_count')
            ->take($limit)
            ->get();
    }

    #[Override]
    public function getContinueWatching(int $limit): Collection
    {
        return Movie::query()
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getNewReleaseMovies(int $limit): Collection
    {
        return Movie::query()
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->latest('release_date')
            ->take($limit)
            ->get();
    }

    // movie controller

    #[Override]
    public function getMovies(?string $search = null): LengthAwarePaginator
    {
        return Movie::query()
            ->withAvg('ratings', 'rating')
            ->when($search, function($query, $search) {
                    return $query->where('title', 'like', "%{$search}%");
            })->latest()
                ->paginate(18)
                ->withQueryString();
    }

    #[Override]
    public function showMovie(Movie $movie): Movie
    {
        return $movie->loadAvg('ratings', 'rating')
                ->loadCount('ratings')
                ->load(['categories', 'writers', 'directors', 'stars']);

    }

    #[Override]
    public function watchMovie(Movie $movie): Movie
    {
        return $movie->load(['ratings']);
    }

    public function getAverageRating(): ?int
    {
        return Movie::query()
            ->ratings()
            ->avg('rating');
    }

}
