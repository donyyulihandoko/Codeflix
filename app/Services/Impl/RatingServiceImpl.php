<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Models\Movie;
use App\Models\Rating;
use App\Repositories\RatingRepository;
use App\Services\RatingService;
use Override;

class RatingServiceImpl implements RatingService
{
    public function __construct(private RatingRepository $ratingRepository)
    {
        //
    }

    #[Override]
    public function rateMovie(User $user, Movie $movie, float $rating): Rating
    {
        $attribute = [
            'user_id' => $user->id,
            'movie_id' => $movie->id
        ];

        $value = ['rating' => $rating];

        return $this->ratingRepository->rateMovie($attribute, $value);
    }

    public function getRatingMovieByUser(Movie $movie, User $user): ?Rating
    {
        return $this->ratingRepository->getRatingMovieByUser($user->id, $movie->id);
    }

}
