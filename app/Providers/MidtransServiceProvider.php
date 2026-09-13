<?php

namespace App\Providers;

use App\Repositories\Impl\PaymentRepositoryImpl;
use App\Repositories\Impl\SubscriptionRepositoryImpl;
use App\Repositories\PaymentRepository;
use App\Repositories\SubscriptionRepository;
use App\Services\Impl\MidtransServiceImpl;
use App\Services\MidtransService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Override;

class MidtransServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MidtransService::class, MidtransServiceImpl::class);
        $this->app->bind(PaymentRepository::class, PaymentRepositoryImpl::class);
        $this->app->bind(SubscriptionRepository::class, SubscriptionRepositoryImpl::class);
    }

    #[Override]
    public function provides()
    {
        return [
            MidtransService::class,
            PaymentRepository::class,
            SubscriptionRepository::class
        ];
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
