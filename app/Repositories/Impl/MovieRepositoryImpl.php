<?php

namespace App\Repositories\Impl;

use App\Models\Category;
use App\Repositories\MovieRepository;
use Override;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Rating;

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
    public function getTrendingMovies(int $limit = 6): Collection
    {
        return Movie::query()
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->latest()
            ->take($limit)
            ->get();
    }

    // public function getTopRateMovies(int $limit = 6): Collection
    // {
    //     return Movie::query()
    //         ->withAvg('ratings', 'rating')
    //         ->withCount('ratings')
    //         ->having('ratings_avg_rating', '>', 2)
    //         ->orderByDesc('ratings_avg_rating')
    //         ->orderByDesc('ratings_count')
    //         ->take($limit)
    //         ->get();
    // }

    public function getTopRateMovies(int $limit = 6): Collection
    {
        return Movie::query()
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->whereIn('id', function ($query) {
                $query->select('movie_id')
                    ->from('ratings')
                    ->groupBy('movie_id')
                    ->havingRaw('AVG(rating) > ?', [2]);
            })
            ->orderByDesc('ratings_avg_rating')
            ->orderByDesc('ratings_count')
            ->take($limit)
            ->get();
    }

    #[Override]
    public function getContinueWatching(int $limit = 6): Collection
    {
        return Movie::query()
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getNewReleaseMovies(int $limit = 6): Collection
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
            ->when($search, function($query, $search)
            {
                    return $query->where(function ($q) use($search) {
                            // cari berdasarkan judul filem
                        $q->where('title', 'like' , "%{$search}%")
                                // cari berdasarkan directors
                            ->orWhereHas('directors', function ($crewQuery) use($search) {
                                $crewQuery->where('name', 'like' , "%{$search}%");
                            })
                                // cari berdasarkan writers
                            ->orWhereHas('writers', function ($crewQuery) use($search) {
                                $crewQuery->where('name', 'like' , "%{$search}%");
                            })
                               // cari berdasarkan writers
                            ->orWhereHas('stars', function ($crewQuery) use($search) {
                                $crewQuery->where('name', 'like' , "%{$search}%");
                            });
                    });
            })
                ->latest()
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

    // public function getAverageRating(): ?float
    // {
    //     return Movie::query()
    //         ->ratings()
    //         ->avg('rating');
    // }


    // #[Override]
    // public function getAverageRating(): ?float
    // {
    //     $avg = Rating::query()->avg('rating');

    //     return $avg !== null ? (float) $avg : null;
    // }

    #[Override]
    public function getMoviesByCategory(Category $category, ?string $search = null): LengthAwarePaginator
    {
        return Movie::query()
            ->when($category, function($q, $category) {
                $q->whereHas('categories', function ($query) use ($category) {
                    $query->where('slug', $category->slug);
                });
            })
            ->withAvg('ratings', 'rating')
            ->when($search, function($query, $search)
            {
                    return $query->where(function ($q) use($search) {
                            // cari berdasarkan judul filem
                        $q->where('title', 'like' , "%{$search}%")
                                // cari berdasarkan directors
                            ->orWhereHas('directors', function ($crewQuery) use($search) {
                                $crewQuery->where('name', 'like' , "%{$search}%");
                            })
                                // cari berdasarkan writers
                            ->orWhereHas('writers', function ($crewQuery) use($search) {
                                $crewQuery->where('name', 'like' , "%{$search}%");
                            })
                               // cari berdasarkan writers
                            ->orWhereHas('stars', function ($crewQuery) use($search) {
                                $crewQuery->where('name', 'like' , "%{$search}%");
                            });
                    });
            })
                ->latest()
                ->paginate(18)
                ->withQueryString();
    }

}
