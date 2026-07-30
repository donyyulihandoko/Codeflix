<?php

namespace App\Repositories;

use App\Models\Subscription;

interface UserRepository
{
    public function hasSubscriptionPlan(int $userId): bool;

    public function getCurrentUserSubscriptionPlan(int $userId): Subscription;
}
