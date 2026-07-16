<?php

namespace App\Services\Impl;

use App\Services\UserService;
use Override;
use App\Models\User;
use App\Repositories\UserRepository;

class UserServiceImpl implements UserService
{

    public function __construct(private UserRepository $userRepository)
    {
        //
    }

    #[Override]
    public function hasSubscriptionPlan(int $userId): bool
    {
        return $this->userRepository->hasSubscriptionPlan($userId);
    }
}
