<?php

namespace App\Services\Impl;

use App\Models\Crew;
use App\Repositories\CrewRepository;
use App\Services\CrewService;
use Illuminate\Pagination\LengthAwarePaginator;
use Override;

class CrewServiceImpl implements CrewService
{
    public function __construct(private CrewRepository $crewRepository)
    {
        //
    }

    #[Override]
    public function getProfileCrew(Crew $crew): Crew
    {
        return $this->crewRepository->getCrewWithMovies($crew);
    }

    #[Override]
    public function getAllCrews(?string $search = null): LengthAwarePaginator
    {
        return $this->crewRepository->getAllCrews($search);
    }
}
