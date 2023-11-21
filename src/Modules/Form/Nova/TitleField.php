<?php

namespace Webid\CmsNova\Modules\Form\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Resource;
use Webid\CmsNova\Modules\Form\Models\TitleField as TitleFieldModel;
use Webid\TranslatableItemField\Translatable;

class TitleField extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = TitleFieldModel::class;

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
        return __('Title field');
    }

    /**
     * @return null|array|string
     */
    public static function singularLabel()
    {
        return __('Title fields');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     *
     * @throws \Exception
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Translatable::make(__('Title'), 'title')
                ->rules('required')
                ->singleLine(),
        ];
    }
}
