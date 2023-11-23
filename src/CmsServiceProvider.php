<?php

namespace Webid\CmsNova;

use App\Models\Template as TemplateModel;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Spatie\Honeypot\ProtectAgainstSpam;
use Webid\CmsNova\App\Console\Commands\GenerateComponent;
use Webid\CmsNova\App\Http\Middleware\CheckLanguageExist;
use Webid\CmsNova\App\Http\Middleware\IsAjax;
use Webid\CmsNova\App\Http\Middleware\Language;
use Webid\CmsNova\App\Http\Middleware\RedirectionParentChild;
use Webid\CmsNova\App\Http\Middleware\RedirectToHomepage;
use Webid\CmsNova\App\Nova\Menu\Menu;
use Webid\CmsNova\App\Nova\Menu\MenuCustomItem;
use Webid\CmsNova\App\Nova\Popin\Popin;
use Webid\CmsNova\App\Nova\Template;
use Webid\CmsNova\App\Observers\TemplateObserver;
use Webid\CmsNova\App\Providers\ViewServiceProvider;
use Webid\CmsNova\App\Services\DynamicResource;
use Webid\CmsNova\App\Services\LanguageService;
use Webid\CmsNova\App\Services\MenuService;
use Webid\CmsNova\App\Services\Sitemap\SitemapGenerator;

class CmsServiceProvider extends ServiceProvider
{
    public function boot(UrlGenerator $generator, Router $router): void
    {
        if (! app()->isLocal()) {
            $generator->forceScheme('https');
        }

        $this->app->singleton(DynamicResource::class);
        $this->app->singleton(MenuService::class);
        $this->app->singleton(SitemapGenerator::class);

        $this->registerMenuDirective();

        $this->publishConfiguration();
        $this->publishProvider();
        $this->publishViews();
        $this->publishPublicFiles();
        $this->publishTemplateModel();
        $this->publishNovaComponents();
        $this->publishTranslations();
        $this->publishServices();
        $this->publishCommands();

        $this->registerAliasMiddleware($router);
        $router->pushMiddlewareToGroup('redirect-parent-child', RedirectionParentChild::class);

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/ajax.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        Nova::serving(function (ServingNova $event) {
            // Model Observers
            TemplateModel::observe(TemplateObserver::class);
        });

        $this->app->booted(function () {
            Nova::resources([
                Template::class,
                Popin::class,
                Menu::class,
                MenuCustomItem::class,
            ]);
        });

        JsonResource::withoutWrapping();

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateComponent::class,
            ]);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../publish/config/cms.php', 'cms');

        Route::pattern('id', '[0-9]+');
        Route::pattern('lang', '(' . app(LanguageService::class)->getAllLanguagesAsRegex() . ')');

        $this->app->register(ViewServiceProvider::class);
    }

    protected function registerMenuDirective(): void
    {
        Blade::directive('menu', function ($expression) {
            /** @var string $expression */
            $expression = str_replace("'", "\\'", $expression);

            return "<?php echo app('" . MenuService::class . "')->showMenu('{$expression}'); ?>";
        });
    }

    protected function publishConfiguration(): void
    {
        $this->publishes([
            __DIR__ . '/../publish/config/translatable.php' => config_path('translatable.php'),
            __DIR__ . '/../publish/config/components.php' => config_path('components.php'),
            __DIR__ . '/../publish/config/cms.php' => config_path('cms.php'),
        ], 'config');
    }

    protected function publishViews(): void
    {
        $this->publishes([
            __DIR__ . '/../publish/resources/views' => base_path('/resources/views'),
        ], 'views');
    }

    protected function publishProvider(): void
    {
        $this->publishes([
            __DIR__ . '/../publish/app/Providers/NovaServiceProvider.php' => base_path(
                '/app/Providers/NovaServiceProvider.php'
            ),
        ], 'providers');
    }

    protected function publishPublicFiles(): void
    {
        $this->publishes([
            __DIR__ . '/../publish/public/cms' => base_path('/public/cms'),
        ], 'public');
    }

    protected function publishNovaComponents(): void
    {
        $this->publishes([
            __DIR__ . '/../publish/nova-components/ComponentItemField' => base_path(
                '/nova-components/ComponentItemField'
            ),
        ], 'nova-components');
    }

    protected function publishTemplateModel(): void
    {
        $this->publishes([
            __DIR__ . '/../publish/app/models/Template.php' => base_path('/app/Models/Template.php'),
        ], 'template-model');
    }

    protected function publishTranslations(): void
    {
        $this->publishes([
            __DIR__ . '/../publish/lang' => base_path('/lang'),
        ], 'translations');
    }

    protected function publishServices(): void
    {
        $this->publishes([
            __DIR__ . '/../publish/services/ExtraElementsForPageService.php' => base_path(
                '/app/Services/ExtraElementsForPageService.php'
            ),
            __DIR__ . '/../publish/services/ComponentsService.php' => base_path('/app/Services/ComponentsService.php'),
        ], 'services');
    }

    protected function publishCommands(): void
    {
        $this->publishes([
            __DIR__ . '/../publish/app/Console' => app_path('Console'),
        ], 'commands');
    }

    protected function registerAliasMiddleware(Router $router): void
    {
        // Alias middlewares
        $router->aliasMiddleware('anti-spam', ProtectAgainstSpam::class);
        $router->aliasMiddleware('language', Language::class);
        $router->aliasMiddleware('check-language-exist', CheckLanguageExist::class);
        $router->aliasMiddleware('is-ajax', IsAjax::class);
        $router->aliasMiddleware('redirect-to-homepage', RedirectToHomepage::class);

        // Create middleware groups
        $router->middlewareGroup('pages', []);
        $router->middlewareGroup('ajax', [
            StartSession::class,
            'is-ajax',
            VerifyCsrfToken::class,
            EncryptCookies::class,
        ]);
    }
}
