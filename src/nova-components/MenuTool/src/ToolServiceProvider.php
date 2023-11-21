<?php

namespace Webid\MenuTool;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;
use Webid\MenuTool\Http\Middleware\Authorize;

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

        Nova::router(['nova', Authenticate::class, Authorize::class], 'menu-tool')
            ->group(__DIR__ . '/../routes/inertia.php')
        ;
    }
}
