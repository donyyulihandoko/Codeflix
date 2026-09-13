<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\MovieService;
use App\Services\PlanService;
use App\Services\UserService;
use App\Services\RatingService;
use App\Services\SubscriptionService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function __construct(private MovieService $movieService, private SubscriptionService $subscriptionService, private PlanService $planService, private RatingService $ratingService)
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
            'movie' => $this->movieService->watchMovie($movie),
            'subscription' => $this->subscriptionService->getCurrentSubscriptionPlan(Auth::user()),
            'plans' => $this->planService->getPlanByName(),
            'userRating' => $this->ratingService->getRatingMovieByUser($movie, Auth::user())
        ]);
    }
}
