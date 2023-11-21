<?php

namespace Webid\CmsNova\Modules\JavaScript\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Webid\CmsNova\App\Nova\Components\CodeSnippetComponent;
use Webid\CmsNova\App\Services\DynamicResource;
use Webid\CmsNova\Modules\JavaScript\Nova\CodeSnippet;

class JavaScriptServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'JavaScript';
    protected string $moduleNameLower = 'javascript';

    public function boot(): void
    {
        $this->registerAndPublishViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        $this->app->booted(function () {
            Nova::resources([
                CodeSnippet::class,
                CodeSnippetComponent::class,
            ]);
        });

        DynamicResource::pushTopLevelResource([
            'label' => __('Code snippet'),
            'resources' => [
                CodeSnippet::class,
            ],
            'icon' => 'user',
        ]);
    }

    protected function registerAndPublishViews(): void
    {
        $destinationPath = resource_path('views/components');
        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $destinationPath,
        ], [
            "{$this->moduleNameLower}-module",
            "{$this->moduleNameLower}-module-views",
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/components';
        }, Config::get('view.paths')), [$sourcePath]), $this->moduleName);
    }
}
