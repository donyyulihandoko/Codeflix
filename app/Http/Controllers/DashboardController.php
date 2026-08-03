<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Response;
use App\Models\Category;
use App\Services\CategoryService;

class DashboardController extends Controller
{
    public function __construct(private MovieService $movieService, private CategoryService $categoryService)
    {
        //
    }

    public function index(): Response
    {
        return response()->view('dashboard', [
            'heroMovie' => $this->movieService->getHeroMovie(),
            'newReleaseMovies' => $this->movieService->getNewReleaseMovies(6),
            'topRateMovies' => $this->movieService->getTopRateMovies(6),
            'trendingMovies' => $this->movieService->getTredingMovies(6),
            'categories' => $this->categoryService->getCategories()
        ]);
    }
}
