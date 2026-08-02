<?php

namespace App\Providers;

use App\Repositories\Impl\MyListRepositoryImpl;
use App\Repositories\MyListRepository;
use App\Services\Impl\MyListServiceImpl;
use App\Services\MyListService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Override;

class MyListServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MyListService::class, MyListServiceImpl::class);
        $this->app->singleton(MyListRepository::class, MyListRepositoryImpl::class);
    }

    #[Override]
    public function provides(): array
    {
        return [
            MyListRepository::class,
            MyListService::class
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
