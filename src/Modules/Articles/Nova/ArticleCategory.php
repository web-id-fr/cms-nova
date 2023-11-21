<?php

namespace Webid\CmsNova\Modules\Articles\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Resource;
use Webid\CmsNova\Modules\Articles\Models\ArticleCategory as ArticleCategoryModel;
use Webid\TranslatableItemField\Translatable;

class ArticleCategory extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = ArticleCategoryModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * @return null|array|string
     */
    public static function label()
    {
        return __('Categories');
    }

    /**
     * @return null|array|string
     */
    public static function singularLabel()
    {
        return __('Category');
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

            Translatable::make(__('Name'), 'name')
                ->singleLine()
                ->rules('required'),
        ];
    }
}
