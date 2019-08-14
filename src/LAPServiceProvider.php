<?php

namespace AlexVanVliet\LAP;

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
        $this->app->singleton(LaravelAdminPanel::class, function () {
            return new LaravelAdminPanel();
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
    }
}
