<?php

namespace App\Services;

use App\Models\Subscription;

interface UserService
{
    public function hasSubscriptionPlan(int $userId): bool;

    public function getCurrentUserSubscriptionPlan(int $userId): Subscription;
}
