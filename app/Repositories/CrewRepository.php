<?php

namespace App\Repositories;

use App\Models\Crew;
use Illuminate\Pagination\LengthAwarePaginator;

interface CrewRepository
{
    public function getCrewWithMovies(Crew $crew): Crew;

    public function getAllCrews(?string $search = null): LengthAwarePaginator;
}
