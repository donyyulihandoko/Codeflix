<?php

namespace App\Services\Impl;

use App\Services\MovieService;
use Override;
use App\Models\Movie;
class MovieServiceImpl implements MovieService
{

    #[Override]
    public function getHeroMovie()
    {
        return Movie::query()
            ->first();
    }

    #[Override]
    public function getContinueWatching()
    {
        return Movie::query()
            ->take(12)
            ->latest()
            ->get();
    }

    #[Override]
    public function getTredingMovie()
    {
        return Movie::query()
            ->take(5)
            ->get();
    }
}
