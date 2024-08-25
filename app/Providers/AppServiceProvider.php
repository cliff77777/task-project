<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FileService;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;



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
        View::addNamespace('mail', resource_path('views/vendor/mail'));
        Paginator::useBootstrap();


        //
    }
}
