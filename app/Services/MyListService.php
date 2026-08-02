<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\User;
use App\Models\MyList;

interface MyListService
{
    public function addMovieToMyList(User $user, Movie $movie): MyList;

    public function getAllMyList(User $user, int $perPage, ?string $search = null);

    public function removeMovieFromMyList(MyList $myList): bool;
}
