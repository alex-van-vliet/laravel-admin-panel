<?php

namespace AlexVanVliet\LAP;

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\ServiceProvider;

class LAPServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LaravelAdminPanel::class, function ($app) {
            return new LaravelAdminPanel($app->make(RouteRegistrar::class));
        });
        $this->app->bind('lap', LaravelAdminPanel::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'lap');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/lap'),
        ]);
    }
}
