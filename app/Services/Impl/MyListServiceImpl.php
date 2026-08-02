<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Models\Movie;
use App\Models\MyList;
use App\Repositories\MyListRepository;
use App\Services\MyListService;
use Exception;
use Override;

class MyListServiceImpl implements MyListService
{

    public function __construct(private MyListRepository $myListRepository)
    {
        //
    }

    #[Override]
    public function addMovieToMyList(User $user, Movie $movie): MyList
    {
        $data = [
            'user_id' => $user->id,
            'movie_id' => $movie->id
        ];
        $myList = $this->myListRepository->create($data);

        if(!$myList->wasRecentlyCreated){
            throw new Exception('This movie is already in your wacth list');
        }

        return $myList;
    }

    #[Override]
    public function getAllMyList(User $user, int $perPage, ?string $search = null)
    {
        return $this->myListRepository->getAllMyLists($user->id, $perPage, $search);
    }

    #[Override]
    public function removeMovieFromMyList(MyList $myList): bool
    {
        return $this->myListRepository->delete($myList);
    }
}
