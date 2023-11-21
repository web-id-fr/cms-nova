<?php

namespace Webid\CmsNova\Modules\Articles\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Webid\CmsNova\App\Services\DynamicResource;
use Webid\CmsNova\Modules\Articles\Models\Article as ArticleModel;
use Webid\CmsNova\Modules\Articles\Nova\Article;
use Webid\CmsNova\Modules\Articles\Nova\ArticleCategory;
use Webid\CmsNova\Modules\Articles\Observers\ArticleObserver;

class ArticlesServiceProvider extends ServiceProvider
{
    public const MODULE_NAME = 'Articles';
    public const MODULE_ALIAS = 'articles';

    public function boot(): void
    {
        $this->publishConfig();
        $this->registerAndPublishViews();
        $this->registerConfig();

        $this->loadMigrationsFrom(module_path(self::MODULE_NAME, 'Database/Migrations'));

        $this->app->booted(function () {
            Nova::resources([
                Article::class,
                ArticleCategory::class,
            ]);
        });

        Nova::serving(function () {
            ArticleModel::observe(ArticleObserver::class);
        });

        DynamicResource::pushTopLevelResource([
            'label' => __('Articles'),
            'resources' => [
                MenuItem::resource(Article::class),
                MenuItem::resource(ArticleCategory::class),
            ],
            'icon' => 'user',
        ]);
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(SitemapServiceProvider::class);
    }

    protected function registerAndPublishViews(): void
    {
        $moduleAlias = self::MODULE_ALIAS;
        $destinationPath = resource_path("views/modules/{$moduleAlias}");
        $sourcePath = module_path(self::MODULE_NAME, 'Resources/views');

        $this->publishes([
            $sourcePath => $destinationPath,
        ], [
            "{$moduleAlias}-module",
            "{$moduleAlias}-module-views",
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) use ($moduleAlias) {
            return $path . "/modules/{$moduleAlias}";
        }, Config::get('view.paths')), [$sourcePath]), $moduleAlias);
    }

    protected function publishConfig(): void
    {
        $moduleAlias = self::MODULE_ALIAS;
        $sourcePath = module_path(self::MODULE_NAME, 'Config');

        $this->publishes([
            $sourcePath . '/articles.php' => config_path('articles.php'),
        ], [
            "{$moduleAlias}-module",
            "{$moduleAlias}-module-config",
        ]);
    }

    protected function registerConfig(): void
    {
        $moduleAlias = self::MODULE_ALIAS;
        $sourcePath = module_path(self::MODULE_NAME, 'Config');

        $this->mergeConfigFrom(
            $sourcePath . '/articles.php',
            $moduleAlias
        );
    }
}
