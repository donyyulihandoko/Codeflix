<?php

namespace App\Providers;

use App\Repositories\CrewRepository;
use App\Repositories\Impl\CrewRepositoryImpl;
use App\Services\CrewService;
use App\Services\Impl\CrewServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class CrewServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CrewService::class, CrewServiceImpl::class);
        $this->app->singleton(CrewRepository::class, CrewRepositoryImpl::class);
    }

    public function provides():array
    {
        return [
            CrewService::class,
            CrewRepository::class
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
