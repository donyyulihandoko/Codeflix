<?php

namespace App\Services;

interface UserService
{
    public function hasSubscriptionPlan(int $userId): bool;
}
