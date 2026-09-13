<?php

namespace App\Repositories;


interface UserRepository
{
    public function hasSubscriptionPlan(int $userId): bool;

}
