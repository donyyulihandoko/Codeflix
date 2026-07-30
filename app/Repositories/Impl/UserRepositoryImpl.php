<?php

namespace App\Repositories\Impl;

use App\Models\Subscription;
use App\Models\User;
use App\Repositories\UserRepository;
use Override;

class UserRepositoryImpl implements UserRepository
{
    #[Override]
    public function hasSubscriptionPlan(int $userId): bool
    {
        return User::query()
            ->findOrFail($userId)
            ->subscriptions()
            ->where('active', true)
            ->where('end_date', '>', now())
            ->exists();
    }

    #[Override]
    public function getCurrentUserSubscriptionPlan(int $userId): Subscription
    {
        return User::query()
            ->findOrFail($userId)
            ->subscriptions()
            ->where('active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with('plan')
            ->latest()
            ->first();
    }
}
