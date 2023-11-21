<?php

namespace Webid\ComponentTool;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class ComponentTool extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     */
    public function boot()
    {
        Nova::script('component-tool', __DIR__ . '/../dist/js/tool.js');
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @return mixed
     */
    public function menu(Request $request)
    {
        return MenuSection::make('Component Tool')
            ->path('/component-tool')
            ->icon('server')
        ;
    }
}
