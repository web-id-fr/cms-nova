<?php

namespace Webid\CmsNova\App\Nova\Menu;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Webid\CmsNova\App\Models\Menu\Menu as MenuModel;
use Webid\MenuItemField\MenuItemField;

class Menu extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = MenuModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
    ];

    /**
     * @return null|array|string
     */
    public static function label()
    {
        return __('Menus');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Title'), 'title')
                ->rules('required'),

            MenuItemField::make(__('Menu'), 'menu_item')
                ->hideFromIndex(),
        ];
    }
}
