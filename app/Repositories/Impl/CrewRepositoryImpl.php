<?php

namespace App\Repositories\Impl;

use App\Models\Crew;
use App\Repositories\CrewRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Override;

class CrewRepositoryImpl implements CrewRepository
{
    #[Override]
    public function getCrewWithMovies(Crew $crew): Crew
    {
        return $crew->load([
            'directedMovies', // Relasi ke film sebagai Sutradara
            'writtenMovies',  // Relasi ke film sebagai Penulis
            'starredMovies',  // Relasi ke film sebagai Aktor/Aktris
        ]);
    }

    #[Override]
    public function getAllCrews(?string $search = null): LengthAwarePaginator
    {
        return Crew::query()
            ->withCount(['directedMovies', 'starredMovies', 'writtenMovies'])
            ->when($search, function($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })->latest()
                ->paginate(18)
                ->withQueryString();;
    }
}
