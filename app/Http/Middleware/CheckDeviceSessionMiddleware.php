<?php

namespace App\Http\Middleware;

use App\Services\DeviceService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckDeviceSessionMiddleware
{
    public function __construct(private DeviceService $deviceService)
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
        if(Auth::check()){

            $isDeviceValid = $this->deviceService->getValidDevice();

            if (!$isDeviceValid) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('error', 'Sesi Anda telah diakhiri dari perangkat lain.');
            }
        }
        return $next($request);
    }
}
