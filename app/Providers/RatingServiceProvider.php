<?php

namespace App\Providers;

use App\Repositories\Impl\RatingRepositoryImpl;
use App\Repositories\RatingRepository;
use App\Services\Impl\RatingServiceImpl;
use App\Services\RatingService;
use Illuminate\Support\ServiceProvider;
use Override;

class RatingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RatingService::class, RatingServiceImpl::class);
        $this->app->singleton(RatingRepository::class, RatingRepositoryImpl::class);
    }

    #[Override]
    public function provides(): array
    {
        return [
            RatingRepository::class,
            RatingService::class
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
