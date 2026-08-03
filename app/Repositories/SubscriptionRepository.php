<?php

namespace App\Repositories;

use App\Models\Subscription;

interface SubscriptionRepository
{
    public function create(array $data): Subscription;

    public function getCurrentSubscriptionPlan(int $userId): Subscription;

}
