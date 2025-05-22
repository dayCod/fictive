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
        $this->mergeConfigFrom(__DIR__.'/../config/fictive.php', 'fictive');

        $this->app->singleton(Fictive::class, fn ($app): \Daycode\Fictive\Fictive => new Fictive);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/fictive.php' => config_path('fictive.php'),
        ], 'fictive-config');
    }
}
