<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Services\CrewService;
use Illuminate\Http\Response;

class CrewController extends Controller
{
    public function __construct(private CrewService $crewService)
    {
        //
    }

    public function index(): Response
    {
        return response()->view('crews.index');
    }

    public function show(Crew $crew): Response
    {
        return response()->view('crews.show', [
            'crew' => $this->crewService->getProfileCrew($crew)
        ]);
    }
}
