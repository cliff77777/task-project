<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FileService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FileService::class, function ($app) {
            return new FileService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
