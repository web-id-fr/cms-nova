<?php

namespace App\Providers;

use App\Nova\Dashboards\Main;
use App\Nova\User;
use App\Services\ComponentsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Oneduo\NovaFileManager\NovaFileManager;
use Webid\CmsNova\App\Nova\Menu\Menu as MenuModule;
use Webid\CmsNova\App\Nova\Menu\MenuCustomItem;
use Webid\CmsNova\App\Nova\Popin\Popin;
use Webid\CmsNova\App\Nova\Template;
use Webid\ComponentTool\ComponentTool;
use Webid\LanguageTool\LanguageTool;
use Webid\MenuTool\MenuTool;
use Webid\SwitchLanguage\SwitchLanguage;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        parent::boot();

        $this->app->singleton(ComponentsService::class);

        Nova::mainMenu(function (Request $request, Menu $menu) {
            return [
                MenuSection::make('Dashboard')
                    ->path('/dashboards/main'),

                MenuSection::make(__('Filemanager'))
                    ->path('/nova-file-manager')
                    ->icon('photograph'),

                MenuSection::make(__('Languages'))
                    ->path('/language-tool')
                    ->icon('translate'),

                MenuSection::make('Menu', [
                    MenuItem::resource(MenuModule::class),
                    MenuItem::resource(MenuCustomItem::class),
                    MenuItem::link(__('Configuration'), '/menu-tool'),
                ])->icon('menu')->collapsable(),

                MenuSection::make('Templates', [
                    MenuItem::link(__('List of Components'), '/component-tool'),
                    MenuItem::resource(Template::class),
                ])->icon('template')->collapsable(),

                MenuSection::resource(Popin::class)
                    ->icon('bell'),

                MenuSection::resource(User::class)
                    ->icon('users'),
            ];
        });
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new LanguageTool(),
            new ComponentTool(),
            new MenuTool(),
            new NovaFileManager(),
            new SwitchLanguage(),
        ];
    }

    /**
     * Register the Nova routes.
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register()
        ;
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new Main(),
        ];
    }
}
