<?php

namespace App\Services;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;

interface SubscriptionService
{
    public function createSubscription(User $user, Plan $plan): Subscription;

    public function getCurrentSubscriptionPlan(User $user): Subscription;
}
