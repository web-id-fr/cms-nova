<?php

namespace Webid\ImageItemField;

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
            Nova::script('image-item-field', __DIR__ . '/../dist/js/field.js');
        });
    }
}
