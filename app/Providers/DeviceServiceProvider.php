<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DeviceService;
use App\Repositories\DeviceRepository;
use App\Services\Impl\DeviceServiceImpl;
use App\Repositories\Impl\DeviceRepositoryImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Override;

class DeviceServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DeviceService::class, DeviceServiceImpl::class);
        $this->app->singleton(DeviceRepository::class, DeviceRepositoryImpl::class);
    }

    #[Override]
    public function provides(): array
    {
        return [
            DeviceService::class,
            DeviceRepository::class
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
