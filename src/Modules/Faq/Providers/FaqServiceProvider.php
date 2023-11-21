<?php

namespace Webid\CmsNova\Modules\Faq\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Webid\CmsNova\App\Services\DynamicResource;
use Webid\CmsNova\Modules\Faq\Nova\Faq;
use Webid\CmsNova\Modules\Faq\Nova\FaqTheme;

class FaqServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Faq';
    protected string $moduleNameLower = 'faq';

    public function boot(): void
    {
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        $this->app->booted(function () {
            Nova::resources([
                Faq::class,
                FaqTheme::class,
            ]);
        });

        DynamicResource::pushTemplateModuleGroupResource([
            'label' => __('Faq'),
            'resources' => [
                MenuItem::resource(Faq::class),
                MenuItem::resource(FaqTheme::class),
            ],
            'icon' => 'user',
        ]);
    }
}
