<?php

namespace App\Providers;

use App\Services\NavigationService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    public function boot(NavigationService $navigationService): void
    {
        View::share('navigationMenu', fn() => $navigationService->getMenu());
    }
}
