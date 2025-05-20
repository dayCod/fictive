<?php

declare(strict_types=1);

namespace Daycode\Fictive;

class FictiveServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Fictive::class, fn ($app): \Daycode\Fictive\Fictive => new Fictive);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
