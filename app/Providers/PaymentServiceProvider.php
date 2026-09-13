<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PaymentService;
use App\Services\Impl\PaymentServiceImpl;
use App\Repositories\PaymentRepository;
use App\Repositories\Impl\PaymentRepositoryImpl;
use Midtrans\Config;

class PaymentServiceProvider extends ServiceProvider implements \Illuminate\Contracts\Support\DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentService::class, PaymentServiceImpl::class);
        $this->app->singleton(PaymentRepository::class, PaymentRepositoryImpl::class);
    }

    public function provides(): array
    {
        return [
            PaymentService::class,
            PaymentRepository::class,
        ];
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Set Konfigurasi Midtrans SDK secara Global
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }
}
