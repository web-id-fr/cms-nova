<?php

namespace Webid\CmsNova\Modules\Slideshow\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Webid\CmsNova\App\Services\DynamicResource;
use Webid\CmsNova\Modules\Slideshow\Nova\Slide;
use Webid\CmsNova\Modules\Slideshow\Nova\Slideshow;

class SlideshowServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Slideshow';
    protected string $moduleNameLower = 'slideshow';

    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        $this->app->booted(function () {
            Nova::resources([
                Slideshow::class,
                Slide::class,
            ]);
        });

        DynamicResource::pushTemplateModuleGroupResource([
            'label' => __('Slideshow'),
            'resources' => [
                MenuItem::resource(Slideshow::class),
                MenuItem::resource(Slide::class),
            ],
            'icon' => 'user',
        ]);
    }
}
