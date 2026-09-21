<?php

namespace App\Providers;

use App\Models\AvanceKpi;
use App\Models\SiteSetting;
use App\Observers\AvanceKpiObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \Filament\Http\Responses\Auth\Contracts\LogoutResponse::class,
            \App\Http\Responses\LogoutResponse::class
        );
    }

    public function boot(): void
    {
        // Compartir $settings en TODAS las vistas
        View::composer('*', function ($view) {
            $view->with('settings', SiteSetting::current());
        });

        // Registrar observer de AvanceKpi
        AvanceKpi::observe(AvanceKpiObserver::class);
    }
}
