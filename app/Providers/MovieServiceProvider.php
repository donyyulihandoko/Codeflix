<?php

namespace App\Providers;

use App\Services\Impl\MovieServiceImpl;
use App\Services\MovieService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class MovieServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MovieService::class, function($app){
            return new MovieServiceImpl();
        });
    }

    public function provides():array
    {
        return [
            MovieService::class
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
