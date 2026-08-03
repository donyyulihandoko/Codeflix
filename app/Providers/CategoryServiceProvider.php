<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\Impl\CategoryRepositoryImpl;
use App\Services\CategoryService;
use App\Services\Impl\CategoryServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Override;

class CategoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryService::class, CategoryServiceImpl::class);
        $this->app->singleton(CategoryRepository::class, CategoryRepositoryImpl::class);
    }

    #[Override]
    public function provides(): array
    {
        return [
            CategoryRepository::class,
            CategoryService::class
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
