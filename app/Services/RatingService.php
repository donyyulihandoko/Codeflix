<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\Rating;
use App\Models\User;

interface RatingService
{
    public function rateMovie(User $user, Movie $movie, float $rating): Rating;

    public function getRatingMovieByUser(Movie $movie, User $user): ?Rating;
}
