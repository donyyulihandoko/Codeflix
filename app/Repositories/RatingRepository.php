<?php

namespace App\Repositories;

use App\Models\Rating;

interface RatingRepository
{
    public function rateMovie(array $attribute, array $value): Rating;

    public function getRatingMovieByUser(int $userId, int $movieId);
}
