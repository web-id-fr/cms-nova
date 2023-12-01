<?php

namespace Webid\ComponentItemField;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('component-item-field', __DIR__.'/../dist/js/field.js');
        });

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

        Route::middleware(['nova'])
            ->namespace('Webid\ComponentItemField\Http\Controllers')
            ->prefix('nova-vendor/component-item-field')
            ->group(__DIR__.'/../routes/ajax.php')
        ;
    }
}
