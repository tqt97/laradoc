<?php

namespace App\Providers;

use App\Data\CustomFrontmatterData;
use App\View\Components\Prezet\Header;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Prezet\Prezet\Data\FrontmatterData;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FrontmatterData::class, CustomFrontmatterData::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        // Removed the broad Gate::after for super-admin bypass as it might interfere
        // with @role directive and specific role checks. Relying on Spatie's @role directive.
        // Gate::after(function ($user, $ability) {
        //     if ($user->hasRole('super-admin')) {
        //         return true;
        //     }
        // });

        Blade::component('prezet.header', Header::class);
    }
}
