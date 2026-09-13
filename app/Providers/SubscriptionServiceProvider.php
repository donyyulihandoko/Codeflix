<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use App\Repositories\SubscriptionRepository;
use App\Repositories\Impl\SubscriptionRepositoryImpl;
use App\Services\SubscriptionService;
use App\Services\Impl\SubscriptionServiceImpl;
use Override;

class SubscriptionServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SubscriptionService::class, SubscriptionServiceImpl::class);
        $this->app->singleton(SubscriptionRepository::class, SubscriptionRepositoryImpl::class);
    }

    #[Override]
    public function provides(): array
    {
        return [
            SubscriptionService::class,
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
