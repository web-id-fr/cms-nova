<?php

namespace Webid\CmsNova\App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (! request()->is('nova*')) {
                $currentLangKey = request()->lang ?? config('app.locale');
                $currentLang = config("translatable.locales.{$currentLangKey}");

                View::share('currentLang', $currentLang);
                View::share('currentLangKey', $currentLangKey);
            }
        });
    }
}
