<?php

namespace App\Repositories\Impl;

use App\Models\Rating;
use App\Repositories\RatingRepository;
use Override;

class RatingRepositoryImpl implements RatingRepository
{
    #[Override]
    public function rateMovie(array $attribute, array $value): Rating
    {
        return Rating::query()->updateOrCreate($attribute, $value);
    }
}
