<?php

namespace App\Providers;

use App\Repositories\Impl\PlanRepositoryImpl;
use App\Repositories\PlanRepository;
use App\Services\Impl\PlanServiceImpl;
use App\Services\PlanService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Override;

class PlanServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PlanService::class, PlanServiceImpl::class);
        $this->app->singleton(PlanRepository::class, PlanRepositoryImpl::class);
    }

    #[Override]
    public function provides() :array
    {
        return [
            PlanService::class,
            PlanRepository::class
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
