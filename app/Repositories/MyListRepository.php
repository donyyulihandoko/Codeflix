<?php

namespace App\Repositories;

use App\Models\MyList;

interface MyListRepository
{
    public function create(array $data): MyList;

    public function getAllMyLists(int $userId, int $perPage, ?string $search = null);

    public function delete(MyList $myList): bool;
}
