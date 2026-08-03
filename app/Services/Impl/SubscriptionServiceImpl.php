<?php

namespace App\Services\Impl;

use App\Models\Plan;
use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use App\Services\SubscriptionService;
use Override;
use App\Models\User;

class SubscriptionServiceImpl implements SubscriptionService
{
    public function __construct(private SubscriptionRepository $subscriptionRepository)
    {
        //
    }

    #[Override]
    public function purchaseSubscription(User $user, Plan $plan): Subscription
    {
        $startDate = now();
        $endDate = $startDate->copy()->addDays((int) $plan->duration);

        $data = [
            'plan_id' => $plan->id,
            'user_id'=> $user->id,
            'active' => true,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        return $this->subscriptionRepository->create($data);
    }

    #[Override]
    public function getCurrentSubscriptionPlan(User $user): Subscription
    {
            return $this->subscriptionRepository->getCurrentSubscriptionPlan($user->id);
    }
}
