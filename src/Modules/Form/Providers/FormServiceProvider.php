<?php

namespace Webid\CmsNova\Modules\Form\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Webid\CmsNova\App\Services\DynamicResource;
use Webid\CmsNova\Modules\Form\Models\Field as FieldModel;
use Webid\CmsNova\Modules\Form\Nova\Field;
use Webid\CmsNova\Modules\Form\Nova\Form;
use Webid\CmsNova\Modules\Form\Nova\Recipient;
use Webid\CmsNova\Modules\Form\Nova\Service;
use Webid\CmsNova\Modules\Form\Nova\TitleField;
use Webid\CmsNova\Modules\Form\Observers\FieldObserver;

class FormServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Form';
    protected string $moduleNameLower = 'form';

    public function boot(): void
    {
        $this->publishConfig();
        $this->publishViews();
        $this->publishJs();
        $this->publishTranslations();
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        $this->app->booted(function () {
            Nova::resources([
                Form::class,
                Field::class,
                TitleField::class,
                Recipient::class,
                Service::class,
            ]);
        });

        View::share('maxFiles', config('dropzone.max-files'));
        View::share('maxTotalSize', config('dropzone.max-file-size'));

        DynamicResource::pushTemplateModuleGroupResource([
            'label' => __('Form'),
            'resources' => [
                MenuItem::resource(Form::class),
                MenuItem::resource(Field::class),
                MenuItem::resource(TitleField::class),
                MenuItem::resource(Service::class),
                MenuItem::resource(Recipient::class),
            ],
            'icon' => 'user',
        ]);

        Nova::serving(function (ServingNova $event) {
            FieldModel::observe(FieldObserver::class);
        });
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function publishTranslations(): void
    {
        $langPath = resource_path('lang');
        $sourcePath = module_path($this->moduleName, 'Resources/lang');

        $this->publishes([
            $sourcePath => $langPath,
        ], [
            $this->moduleNameLower . '-module',
            $this->moduleNameLower . '-module-lang',
        ]);
    }

    protected function registerConfig(): void
    {
        $sourcePath = module_path($this->moduleName, 'Config');

        $this->mergeConfigFrom(
            $sourcePath . '/fields_type.php',
            $this->moduleNameLower
        );
        $this->mergeConfigFrom(
            $sourcePath . '/fields_type_validation.php',
            $this->moduleNameLower
        );
        $this->mergeConfigFrom(
            $sourcePath . '/form.php',
            $this->moduleNameLower
        );
    }

    protected function publishConfig(): void
    {
        $sourcePath = module_path($this->moduleName, 'Config');

        $this->publishes([
            $sourcePath . '/dropzone.php' => config_path('dropzone.php'),
            $sourcePath . '/fields_type.php' => config_path('fields_type.php'),
            $sourcePath . '/fields_type_validation.php' => config_path('fields_type_validation.php'),
            $sourcePath . '/form.php' => config_path('form.php'),
        ], [
            $this->moduleNameLower . '-module',
            $this->moduleNameLower . '-module-config',
        ]);
    }

    protected function publishJs(): void
    {
        $jsPath = resource_path('js');
        $sourcePath = module_path($this->moduleName, 'Resources/js');

        $this->publishes([
            $sourcePath . '/send_form.js' => $jsPath . '/send_form.js',
            $sourcePath . '/send_form_popin.js' => $jsPath . '/send_form_popin.js',
            $sourcePath . '/helpers.js' => $jsPath . '/helpers.js',
        ], [
            $this->moduleNameLower . '-module',
            $this->moduleNameLower . '-module-js',
        ]);
    }

    protected function publishViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);
        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], [
            $this->moduleNameLower . '-module',
            $this->moduleNameLower . '-module-views',
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . "/modules/{$this->moduleNameLower}";
        }, Config::get('view.paths')), [$sourcePath]), $this->moduleNameLower);
    }
}
