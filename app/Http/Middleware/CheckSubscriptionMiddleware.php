<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;

class CheckSubscriptionMiddleware
{

    public function __construct(private UserService $userService)
    {
        //
    }

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $activeMember = $this->userService->hasSubscriptionPlan(Auth::user()->id);

        if (!$activeMember) {
            return to_route('subscriptions.index');
        } else {
            return $next($request);
        }
    }
}
