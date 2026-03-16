<?php

namespace App\Providers;

use App\Services\Feature;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class FeatureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Feature::class, function ($app) {
            return new Feature;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('feature', function (string $feature) {
            return app(Feature::class)->isEnabled($feature);
        });
    }
}
