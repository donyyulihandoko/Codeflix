<?php

namespace App\Services;
use App\Models\Crew;
use Illuminate\Pagination\LengthAwarePaginator;

interface CrewService
{
    public function getProfileCrew(Crew $crew): Crew;

    public function getAllCrews(?string $search = null): LengthAwarePaginator;
}
