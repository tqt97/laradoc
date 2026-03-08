<?php

namespace App\Providers;

use App\Data\CustomFrontmatterData;
use Illuminate\Pagination\Paginator;
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
    }
}
