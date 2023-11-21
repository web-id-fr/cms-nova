<?php

namespace Webid\SwitchLanguage;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Webid\SwitchLanguage\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
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

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/switch-language')
            ->group(__DIR__ . '/../routes/api.php')
        ;
    }
}
