<?php

namespace App\Http\Middleware;

use App\Services\SubscriptionService;
use App\Services\DeviceService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeviceLimitMiddleware
{
    public function __construct(private DeviceService $deviceService, private SubscriptionService $subscriptionService)
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
        $user = $request->user();

        // 1. Jika user tidak login, lewati (biarkan middleware 'auth' yang menangani)
        if (!$user) {
            return $next($request);
        }

        $subscription = $this->subscriptionService->getCurrentSubscriptionPlan($user);
        $maxDevice = ($subscription && $subscription->plan) ? $subscription->plan->max_devices : 1;
        $deviceCount = $this->deviceService->countUserDevice($user);

        if($deviceCount > $maxDevice)
        {
            return redirect()->route('devices.index');
        }

        return $next($request);
    }
}
