<?php

namespace Webid\SwitchLanguage;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Webid\CmsNova\App\Services\LanguageService;

class SwitchLanguage extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     */
    public function boot()
    {
        Nova::script('switch-language', __DIR__ . '/../dist/js/tool.js');
        Nova::provideToScript([
            'language_switcher' => [
                'languages' => Arr::wrap(app(LanguageService::class)->getUsedLanguage()),
            ],
        ]);
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @return mixed
     */
    public function menu(Request $request)
    {
        return MenuSection::make('Switch Language')
            ->path('/switch-language')
            ->icon('server')
        ;
    }
}
