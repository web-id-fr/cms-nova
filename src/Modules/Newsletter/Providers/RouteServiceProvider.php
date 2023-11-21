<?php

namespace Webid\CmsNova\Modules\Newsletter\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Webid\CmsNova\Modules\Newsletter\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->mapAjaxRoutes();
    }

    /**
     * Define the "ajax" routes for the application.
     *
     * These routes are for nova only.
     */
    protected function mapAjaxRoutes()
    {
        Route::middleware('ajax')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Newsletter', 'Routes/ajax.php'))
        ;
    }
}
