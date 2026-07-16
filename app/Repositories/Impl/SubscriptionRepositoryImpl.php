<?php

namespace App\Repositories\Impl;

use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use Illuminate\Support\Facades\DB;
use Override;


class SubscriptionRepositoryImpl implements SubscriptionRepository
{
    #[Override]
    public function create(array $data): Subscription
    {
        return DB::transaction(function() use ($data)
        {
            return Subscription::query()
                        ->create($data);
        });
    }
}
