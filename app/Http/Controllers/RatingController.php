<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRatingRequest;
use App\Services\RatingService;
use Illuminate\Http\RedirectResponse;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function __construct(private RatingService $ratingService)
    {
        //
    }

    public function store(StoreRatingRequest $request, Movie $movie): RedirectResponse
    {

        $this->ratingService->rateMovie(
            user: Auth::user(),
            movie: $movie,
            rating: $request->validated('rating')
        );

        return back()->with('success', 'Thanks for rating this movie!');
    }
}
