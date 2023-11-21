<?php

namespace Webid\MenuTool;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class MenuTool extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     */
    public function boot()
    {
        Nova::script('menu-tool', __DIR__ . '/../dist/js/tool.js');
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @return mixed
     */
    public function menu(Request $request)
    {
        return MenuSection::make('Menu Tool')
            ->path('/menu-tool')
            ->icon('server')
        ;
    }
}
