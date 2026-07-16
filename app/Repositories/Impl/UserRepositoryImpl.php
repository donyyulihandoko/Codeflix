<?php

namespace App\Repositories\Impl;

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
}
