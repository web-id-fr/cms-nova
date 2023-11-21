<?php

namespace Webid\LanguageTool;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;
use Webid\LanguageTool\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->app->booted(function () {
            $this->routes();
        });
    }

    /**
     * Register the tool's routes.
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Nova::router(['nova', Authenticate::class, Authorize::class], 'language-tool')
            ->group(__DIR__ . '/../routes/inertia.php')
        ;

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/language-tool')
            ->group(__DIR__ . '/../routes/ajax.php')
        ;
    }
}
