<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Http\Response;

class MovieController extends Controller
{
    public function __construct(private MovieService $movieService)
    {
       //
    }

    public function index(): Response
    {
        return response()->view('movies.index');
    }

    public function show(Movie $movie): Response
    {
        return response()->view('movies.show', [
            'movie' => $this->movieService->showMovie($movie)
        ]);
    }

    public function watch(Movie $movie): Response
    {
        return response()->view('movies.watch', [
            'movie' => $this->movieService->watchMovie($movie)
        ]);
    }
}
