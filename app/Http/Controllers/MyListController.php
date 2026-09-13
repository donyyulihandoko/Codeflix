<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\MyListService;
use Exception;
use App\Models\MyList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MyListController extends Controller
{
    public function __construct(private MyListService $myListService)
    {
        //
    }

    public function index(): Response
    {
        return response()->view('my-lists.index');
    }

    public function store(Movie $movie): RedirectResponse
    {
        try {
            $this->myListService->addMovieToMyList(Auth::user(), $movie);
            return back()->with('success', 'Success add this Movie to Your List');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function destroy(MyList $myList): RedirectResponse
    {
        try {
            $this->myListService->removeMovieFromMyList($myList);
            return back()->with('success', 'Success remove this Movie from Your List');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
