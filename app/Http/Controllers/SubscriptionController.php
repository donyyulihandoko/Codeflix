<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Services\PlanService;
use App\Services\SubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Midtrans\Transaction;

class SubscriptionController extends Controller
{
    public function __construct(private PlanService $planService, private SubscriptionService $subscriptionService)
    {
        //
    }

    public function index(): Response
    {
        return response()->view('subscriptions.index');
    }

    public function show(Plan $plan): Response
    {
        return response()->view('subscriptions.show', [
            'plan' => $this->planService->getPlanDetails($plan),

        ]);
    }

    public function purchase(Plan $plan): RedirectResponse
    {
        $this->subscriptionService->purchaseSubscription(Auth::user(), $plan);
        return to_route('subscriptions.success');
    }

    public function success(): Response
    {
        return response()->view('subscriptions.success');
    }
}
