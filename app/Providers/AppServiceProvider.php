<?php

namespace App\Providers;

use App\Services\GraduationService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Mendaftarkan service agar dapat di-inject
        $this->app->singleton(GraduationService::class, function ($app) {
            return new GraduationService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Paginator::useBootstrap(); // Ini akan mengatur agar pagination menggunakan Bootstrap 4/5
    }
}
