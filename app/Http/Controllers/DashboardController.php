<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function __construct(private MovieService $movieService)
    {
        //
    }

    public function index(): Response
    {
        return response()->view('dashboard', [
            'heroMovie' => $this->movieService->getHeroMovie(),
            'trendingMovies' => $this->movieService->getTredingMovies(),
            // 'continueWatcing' => $this->movieService->getContinueWatching(),
        ]);
    }
}
