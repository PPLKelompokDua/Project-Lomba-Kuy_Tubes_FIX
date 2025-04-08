<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Daftarkan namespace komponen untuk exception renderer
        Blade::componentNamespace('Illuminate\Foundation\Exceptions\Views', 'laravel-exceptions-renderer');
    }
    
}
