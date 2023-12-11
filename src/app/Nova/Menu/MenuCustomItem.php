<?php

namespace Webid\CmsNova\App\Nova\Menu;

use Alexwenzel\DependencyContainer\DependencyContainer;
use Alexwenzel\DependencyContainer\HasDependencies;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Webid\AdvancedUrlField\AdvancedUrlField;
use Webid\CmsNova\App\Models\Menu\MenuCustomItem as MenuCustomItemModel;

class MenuCustomItem extends Resource
{
    use HasDependencies;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = MenuCustomItemModel::class;

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
        return __('Menu custom items');
    }

    public function fields(Request $request): array
    {
        return [
            Text::make(__('Title'), 'title'),

            Text::make(__('Menu description'), 'menu_description')
                ->help(__(
                    'This field is optional and allows you to add a short description below the title in the sub-menu.'
                )),

            Select::make(__('Type link'), 'type_link')
                ->options(MenuCustomItemModel::linksTypes())
                ->displayUsingLabels()
                ->hideFromIndex(),

            DependencyContainer::make([
                AdvancedUrlField::make(__('Url'), 'url')
                    ->hideFromIndex(),

                Select::make(__('Target'), 'target')
                    ->options(MenuCustomItemModel::statusTypes())
                    ->displayUsingLabels()
                    ->rules('nullable')
                    ->hideFromIndex(),
            ])->dependsOn('type_link', MenuCustomItemModel::_LINK_URL),
        ];
    }
}
