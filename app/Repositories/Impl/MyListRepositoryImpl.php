<?php

namespace App\Repositories\Impl;

use App\Models\MyList;
use App\Repositories\MyListRepository;
use Override;

class MyListRepositoryImpl implements MyListRepository
{
    #[Override]
    public function create(array $data): MyList
    {
        return MyList::query()
            ->firstOrCreate($data);
    }

    #[Override]
    public function getAllMyLists(int $userId, int $perPage, ?string $search = null)
    {
        return MyList::query()
                ->when($search, function($q, $search){
                    $q->whereHas('movie', function ($q) use($search) {
                        $q->where('title', 'like',  "%{$search}%");
                    });
                })
                ->where('user_id', $userId)
                ->whereHas('movie')
                ->with(['movie' => function($q){
                    $q->select( 'id','title',
                                    'slug',
                                    'description',
                                    'poster',
                                    'release_date',
                                    'duration',)
                        ->withAvg('ratings', 'rating');
                }])
                ->latest()
                ->paginate($perPage);
    }

    #[Override]
    public function delete(MyList $myList): bool
    {
        return $myList->delete();
    }
}
