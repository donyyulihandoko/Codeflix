<?php

namespace App\Providers;

use App\Services\Impl\PaymentCallbackServiceImpl;
use App\Services\PaymentCallbackService;
use Illuminate\Support\ServiceProvider;
use App\Repositories\PaymentRepository;
use App\Repositories\Impl\PaymentRepositoryImpl;
use App\Repositories\SubscriptionRepository;
use App\Repositories\Impl\SubscriptionRepositoryImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Override;

class PaymentCallbackServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentCallbackService::class, PaymentCallbackServiceImpl::class);
        $this->app->bind(PaymentRepository::class, PaymentRepositoryImpl::class);
        $this->app->bind(SubscriptionRepository::class, SubscriptionRepositoryImpl::class);
    }

    #[Override]
    public function provides(): array
    {
        return [
            PaymentCallbackService::class,
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
